<?php

namespace App\Support;

use App\Models\Car;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InputTableActions
{
    public static function get()
    {
        return [
            ActionGroup::make([
                Action::make('viewCalculation')
                    ->button()
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading('Detail Perhitungan')
                    ->modalContent(fn ($record) => view('filament.modals.view-calculation', [
                        'car' => $record,
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->visible(fn ($record) => !is_null($record->dataset_price)),
                EditAction::make()
                    ->button()
                    ->label('Ubah')
                    ->icon('heroicon-o-pencil-square')
                    ->color('success')
                    ->modalHeading('Edit Data')
                    ->form(self::getEditForm())
                    ->after(function (array $data, Car $record) {
                        $changed = $record->wasChanged('region')
                            || $record->wasChanged('manufacturer')
                            || $record->wasChanged('cylinders')
                            || $record->wasChanged('fuel')
                            || $record->wasChanged('odometer')
                            || $record->wasChanged('transmission')
                            || $record->wasChanged('drive')
                            || $record->wasChanged('type')
                            || $record->wasChanged('paint_color')
                            || $record->wasChanged('state')
                            || $record->wasChanged('age')
                            || $record->wasChanged('dataset_price');

                        // Only proceed if dataset_price is not null
                        if ($changed && !is_null($record->dataset_price)) {
                            Log::info('recalculate prediction!');

                            $response = Http::post('https://a760-35-204-56-140.ngrok-free.app/predict', [
                                'region' => $record->region,
                                'manufacturer' => $record->manufacturer,
                                'cylinders' => $record->cylinders,
                                'fuel' => $record->fuel,
                                'odometer' => (int) $record->odometer,
                                'transmission' => $record->transmission,
                                'drive' => $record->drive,
                                'type' => $record->type,
                                'paint_color' => $record->paint_color,
                                'state' => $record->state,
                                'age' => (int) $record->age,
                            ]);

                            if ($response->successful()) {
                                $data['rf'] = $response->json('random_forest');
                                $data['xgb'] = $response->json('xgboost');
                                $data['lgbm'] = $response->json('lightgbm');
                            } else {
                                throw new \Exception(
                                    'Failed to get prediction from API. ' .
                                            'Status: ' . $response->status() . "\n" .
                                            'Body: ' . $response->body()
                                );
                            }

                            $record->predictedPrice()->update([
                                'rf' => $data['rf'],
                                'xgb' => $data['xgb'],
                                'lgbm' => $data['lgbm'],
                            ]);
                        }
                    }),
                DeleteAction::make()
                    ->button()
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->modalHeading('Hapus Data')
                    ->modalDescription("Apakah Anda yakin?")
                    ->modalSubmitActionLabel("Ya, hapus"),
            ])
        ];
    }

    private static function getEditForm()
    {
        return [
            Select::make('region')
                ->native(false)
                ->lazy()
                ->searchable()
                ->options(fn () => DatasetOptions::regions())
                ->required(),
            Select::make('state')
                ->native(false)
                ->lazy()
                ->searchable()
                ->options(fn () => DatasetOptions::states())
                ->required(),
            Select::make('manufacturer')
                ->native(false)
                ->lazy()
                ->searchable()
                ->options(fn () => DatasetOptions::manufacturers())
                ->required(),
            Select::make('paint_color')
                ->native(false)
                ->lazy()
                ->searchable()
                ->options(fn () => DatasetOptions::paintColors())
                ->required(),
            Select::make('fuel')
                ->native(false)
                ->lazy()
                ->searchable()
                ->options(fn () => DatasetOptions::fuels())
                ->required(),
            Select::make('cylinders')
                ->native(false)
                ->lazy()
                ->searchable()
                ->options(fn () => DatasetOptions::cylinders())
                ->required(),
            TextInput::make('odometer')
                ->mask(RawJs::make('$money($input, \'.\', \',\', 0)'))
                ->numeric()
                ->minValue(1)
                ->stripCharacters(',')
                ->required(),
            Select::make('transmission')
                ->native(false)
                ->lazy()
                ->searchable()
                ->options(fn () => DatasetOptions::transmissions())
                ->required(),
            Select::make('drive')
                ->native(false)
                ->lazy()
                ->searchable()
                ->options(fn () => DatasetOptions::drives())
                ->required(),
            Select::make('type')
                ->native(false)
                ->lazy()
                ->searchable()
                ->options(fn () => DatasetOptions::types())
                ->required(),
            TextInput::make('age')
                ->helperText('Tahun penawaran - tahun pembelian baru.')
                ->mask(RawJs::make('$money($input, \'.\', \',\', 0)'))
                ->numeric()
                ->minValue(1)
                ->stripCharacters(',')
                ->required(),
            TextInput::make('dataset_price')
                ->label('Price (Opsional)')
                ->helperText('Masukkan harga dalam Dolar AS')
                ->numeric()
                ->minValue(1)
                ->prefix('$')
                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
        ];
    }
}
