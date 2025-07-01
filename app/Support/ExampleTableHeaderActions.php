<?php

namespace App\Support;

use App\Models\Car;
use App\Models\PredictedPrice;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Support\Facades\Http;

class ExampleTableHeaderActions
{
    public static function get()
    {
        return [
            CreateAction::make()
                ->label('Input Data')
                ->icon('heroicon-o-plus')
                ->modalHeading('Input data mobil')
                ->form([
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
                        ->label('Price')
                        ->helperText('Masukkan harga dalam Dolar AS')
                        ->numeric()
                        ->minValue(1)
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->required()
                ])
                ->mutateFormDataUsing(function (array $data) {
                    $data['from_dataset'] = true;
                    return $data;
                })
                ->after(function (array $data, Car $record) {
                    $response = Http::post('https://e6b1-34-16-240-167.ngrok-free.app/predict', [
                        'region' => $data['region'],
                        'manufacturer' => $data['manufacturer'],
                        'cylinders' => $data['cylinders'],
                        'fuel' => $data['fuel'],
                        'odometer' => (int) $data['odometer'],
                        'transmission' => $data['transmission'],
                        'drive' => $data['drive'],
                        'type' => $data['type'],
                        'paint_color' => $data['paint_color'],
                        'state' => $data['state'],
                        'age' => (int) $data['age'],
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

                    $data['car_id'] = $record->getKey();
                    PredictedPrice::create($data);
                })
        ];
    }
}
