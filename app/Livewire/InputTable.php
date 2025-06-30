<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\PredictedPrice;
use App\Support\DatasetOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Support\RawJs;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class InputTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    private function getQuery()
    {
        return Car::query()
            ->when(true, function ($query) {
                $query->where('from_dataset', false)->with('predictedPrice');
            })
            ->orderByDesc('id');
    }

    private function getColumns()
    {
        return [
            TextColumn::make('region_state')
                ->label("Region / State")
                ->searchable(['region', 'state'])
                ->wrapHeader()
                ->getStateUsing(fn ($record) => "
                    <span class='capitalize'>{$record->region}</span><br>
                    <span class='font-semibold uppercase'>{$record->state}</span>
                ")
                ->html()
                ->wrap(),
            TextColumn::make('manufacturer_paint_color')
                ->label("Manufacturer / Paint Color")
                ->searchable(['manufacturer', 'paint_color'])
                ->wrapHeader()
                ->getStateUsing(fn ($record) => "
                    <span class='font-semibold capitalize'>{$record->manufacturer}</span><br>
                    <span class='capitalize'>{$record->paint_color}</span>
                ")
                ->html()
                ->wrap(),
            TextColumn::make('fuel_cylinders')
                ->label("Fuel / Cylinders")
                ->searchable(['fuel', 'cylinders'])
                ->wrapHeader()
                ->getStateUsing(fn ($record) => "
                    <span class='capitalize font-semibold'>{$record->fuel}</span><br>
                    <span>{$record->cylinders}</span>
                ")
                ->html()
                ->wrap(),
            TextColumn::make('odometer')
                ->searchable()
                ->numeric()
                ->alignEnd(),
            TextColumn::make('transmission_drive')
                ->label("Transmission / Drive")
                ->searchable(['transmission', 'drive'])
                ->wrapHeader()
                ->getStateUsing(fn ($record) => "
                    <span class='capitalize'>{$record->transmission}</span><br>
                    <span class='uppercase font-semibold'>{$record->drive}</span>
                ")
                ->html()
                ->wrap(),
            TextColumn::make('type')
                ->searchable()
                ->extraAttributes(['class' => 'capitalize']),
            TextColumn::make('age')
                ->searchable()
                ->alignEnd(),
            TextColumn::make('dataset_price')
                ->label("Price (opsional)")
                ->searchable()
                ->formatStateUsing(fn ($state) => '$' . number_format($state, 2))
                ->weight(FontWeight::SemiBold)
                ->alignEnd(),
            TextColumn::make('predictedPrice.rf')
                ->label("RF")
                ->searchable()
                ->getStateUsing(function ($record) {
                    if (is_null($record->dataset_price)) {
                        $predicted = number_format($record->predictedPrice->rf ?? 0, 2);

                        return <<<HTML
                            <div class='text-blue-600'>$$predicted</div>
                        HTML;
                    }

                    $actual = $record->dataset_price ?? 0;
                    $predicted = $record->predictedPrice->rf ?? 0;
                    $mae = number_format(abs($predicted - $actual), 2);
                    $mape = number_format(abs(($actual - $predicted) / $actual) * 100, 2);

                    $predicted = number_format($predicted, 2);
                    return <<<HTML
                        <div class='text-blue-600'>$$predicted</div>
                        <div class='text-red-600'>$mae</div>
                        <div class='text-purple-600'>$mape%</div>
                    HTML;
                })
                ->html()
                ->weight(FontWeight::SemiBold)
                ->alignEnd(),
            TextColumn::make('predictedPrice.xgb')
                ->label("XGB")
                ->searchable()
                ->getStateUsing(function ($record) {
                    if (is_null($record->dataset_price)) {
                        $predicted = number_format($record->predictedPrice->xgb ?? 0, 2);

                        return <<<HTML
                            <div class='text-green-600'>$$predicted</div>
                        HTML;
                    }

                    $actual = $record->dataset_price ?? 0;
                    $predicted = $record->predictedPrice->xgb ?? 0;
                    $mae = number_format(abs($predicted - $actual), 2);
                    $mape = number_format(abs(($actual - $predicted) / $actual) * 100, 2);

                    $predicted = number_format($predicted, 2);
                    return <<<HTML
                        <div class='text-green-600'>$$predicted</div>
                        <div class='text-red-600'>$mae</div>
                        <div class='text-purple-600'>$mape%</div>
                    HTML;
                })
                ->html()
                ->weight(FontWeight::SemiBold)
                ->alignEnd(),
            TextColumn::make('predictedPrice.lgbm')
                ->label("LGBM")
                ->searchable()
                ->getStateUsing(function ($record) {
                    if (is_null($record->dataset_price)) {
                        $predicted = number_format($record->predictedPrice->lgbm ?? 0, 2);

                        return <<<HTML
                            <div class='text-yellow-600'>$$predicted</div>
                        HTML;
                    }

                    $actual = $record->dataset_price ?? 0;
                    $predicted = $record->predictedPrice->lgbm ?? 0;
                    $mae = number_format(abs($predicted - $actual), 2);
                    $mape = number_format(abs(($actual - $predicted) / $actual) * 100, 2);

                    $predicted = number_format($predicted, 2);
                    return <<<HTML
                        <div class='text-yellow-600'>$$predicted</div>
                        <div class='text-red-600'>$mae</div>
                        <div class='text-purple-600'>$mape%</div>
                    HTML;
                })
                ->html()
                ->weight(FontWeight::SemiBold)
                ->alignEnd(),
        ];
    }

    private function getBulkActions()
    {
        return [
            BulkAction::make('calculate')
                ->label('Hitung')
                ->icon('heroicon-o-document-text')
                ->modalHeading('Hitung MAE, MAPE, dan R²')
                ->modalContent(fn ($records) => view('filament.modals.calculate', [
                    'cars' => $records,
                ]))
                ->modalSubmitAction(false)
                ->modalCancelAction(false)
        ];
    }

    private function getActions()
    {
        return [
            Action::make('viewCalculation')
                ->label('Detail')
                ->button()
                ->color('warning')
                ->icon('heroicon-o-eye')
                ->modalHeading('Detail Perhitungan')
                ->modalContent(fn ($record) => view('filament.modals.view-calculation', [
                    'car' => $record,
                ]))
                ->modalSubmitAction(false)
                ->modalCancelAction(false)
                ->disabled(fn ($record) => is_null($record->dataset_price)),
            ];
    }

    private function getHeaderActions()
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

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getQuery())
            ->heading("Input Dari User")
            ->description("Harga dan prediksi harga ditampilkan dalam Dolar AS (USD).")
            ->striped()
            ->checkIfRecordIsSelectableUsing(fn ($record) => !is_null($record->dataset_price))
            ->columns($this->getColumns())
            ->filters([])
            ->headerActions($this->getHeaderActions())
            ->bulkActions($this->getBulkActions())
            ->actions($this->getActions());
    }

    public function render()
    {
        return view('livewire.input-table');
    }
}
