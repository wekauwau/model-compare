<?php

namespace App\Support;

use App\Models\Car;
use App\Models\PredictedPrice;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Support\Facades\Http;

class InputTableHeaderActions
{
    public static function get()
    {
        return [
            CreateAction::make()
                ->label('Input Data')
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
                        ->label('Price (Opsional)')
                        ->helperText('Masukkan harga dalam Dolar AS')
                        ->numeric()
                        ->minValue(1)
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                ])
                ->after(function (array $data, Car $car) {
                    $response = Http::post('https://0222-34-127-11-18.ngrok-free.app/predict', [
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

                    // Check if API response is valid
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

                    $data['car_id'] = $car->getKey();
                    PredictedPrice::create($data);
                })
        ];
    }
}
