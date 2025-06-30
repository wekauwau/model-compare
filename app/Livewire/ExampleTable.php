<?php

namespace App\Livewire;

use App\Models\Car;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ExampleTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    private function getQuery()
    {
        return Car::query()
            ->when(true, function ($query) {
                $query->where('from_dataset', true)->with('predictedPrice');
            })
            ->orderByDesc('id');
    }

    private function getColumns()
    {
        return [
            TextColumn::make('region_state')
                ->label("Region / State")
                ->wrapHeader()
                ->searchable(['region', 'state'])
                ->getStateUsing(fn ($record) => "
                    <span class='capitalize'>{$record->region}</span><br>
                    <span class='font-semibold uppercase'>{$record->state}</span>
                ")
                ->html()
                ->wrap(),
            TextColumn::make('manufacturer_paint_color')
                ->label("Manufacturer / Paint Color")
                ->wrapHeader()
                ->searchable(['manufacturer', 'paint_color'])
                ->getStateUsing(fn ($record) => "
                    <span class='font-semibold capitalize'>{$record->manufacturer}</span><br>
                    <span class='capitalize'>{$record->paint_color}</span>
                ")
                ->html()
                ->wrap(),
            TextColumn::make('fuel_cylinders')
                ->label("Fuel / Cylinders")
                ->wrapHeader()
                ->searchable(['fuel', 'cylinders'])
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
                ->wrapHeader()
                ->searchable(['transmission', 'drive'])
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
                ->label("Price")
                ->searchable()
                ->formatStateUsing(fn ($state) => '$' . number_format($state, 2))
                ->weight(FontWeight::SemiBold)
                ->alignEnd(),
            TextColumn::make('predictedPrice.rf')
                ->label("RF")
                ->searchable()
                ->getStateUsing(function ($record) {
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

    private function getActions()
    {
        return [
            Action::make('viewCalculation')
                ->label('Detail')
                ->button()
                ->color('warning')
                ->icon('heroicon-o-eye')
                ->modalHeading('Detail perhitungan')
                ->modalContent(fn ($record) => view('filament.modals.view-calculation', [
                    'car' => $record,
                ]))
                ->modalSubmitAction(false)
                ->modalCancelAction(false)
            ];
    }

    private function getBulkActions()
    {
        return [
            BulkAction::make('calculate')
                ->label('Calculate')
                ->icon('heroicon-o-document-text')
                ->modalHeading('Calculate MAE, MAPE, and R²')
                ->modalContent(fn ($records) => view('filament.modals.calculate', [
                    'cars' => $records,
                ]))
                ->modalSubmitAction(false)
                ->modalCancelAction(false)
            ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getQuery())
            ->heading("Sampel dari dataset")
            ->description("Harga dan prediksi harga ditampilkan dalam Dolar AS (USD).")
            ->striped()
            ->columns($this->getColumns())
            ->filters([])
            ->actions($this->getActions())
            ->bulkActions($this->getBulkActions());
    }

    public function render()
    {
        return view('livewire.example-table');
    }
}
