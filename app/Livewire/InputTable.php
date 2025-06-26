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

class InputTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Car::query()
                    ->when(true, function ($query) {
                        $query->where('from_dataset', false)->with('predictedPrice');
                    })
                    ->orderByDesc('id')
            )
            ->striped()
            ->heading("Input From Users")
            ->columns([
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
                    ->label("Price (optional)")
                    ->searchable()
                    ->money('USD')
                    ->alignEnd()
                    ->weight(FontWeight::SemiBold),
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

                        // Safely handle nulls and object access
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
                    ->alignEnd()
                    ->weight(FontWeight::SemiBold),
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

                        // Safely handle nulls and object access
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
                    ->alignEnd()
                    ->weight(FontWeight::SemiBold),
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

                        // Safely handle nulls and object access
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
                    ->alignEnd()
                    ->weight(FontWeight::SemiBold),
            ])
            ->filters([])
            ->actions([
                Action::make('viewCalculation')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->button()
                    ->color('warning')
                    ->modalHeading('Calculation Detail')
                    ->modalContent(fn ($record) => view('filament.modals.view-calculation', [
                        'car' => $record,
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
            ])
            ->bulkActions([
                BulkAction::make('calculate')
                    ->label('Calculate')
                    ->icon('heroicon-o-document-text')
                    ->modalHeading('Calculate MAE, MAPE, and R²')
                    // ->modalContent(fn (Collection $records) => view('tables.bulk-summary', [
                    //     'records' => $records,
                    // ])),
                    ->modalContent(fn ($records) => view('filament.modals.calculate', [
                        'cars' => $records,
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false),
            ]);
    }

    public function render()
    {
        return view('livewire.input-table');
    }
}
