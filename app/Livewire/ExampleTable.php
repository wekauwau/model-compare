<?php

namespace App\Livewire;

use App\Models\Car;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ExampleTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Car::query()->with('predictedPrice'))
            ->striped()
            ->heading("Sample From Dataset")
            ->columns([
                TextColumn::make('region_state')
                    ->label("Region / State")
                    ->wrapHeader()
                    ->getStateUsing(fn ($record) => "
                            <span class='capitalize'>{$record->region}</span><br>
                            <span class='font-semibold uppercase'>{$record->state}</span>
                        ")
                    ->html()
                    ->wrap(),
                TextColumn::make('manufacturer_paint_color')
                    ->label("Manufacturer / Paint Color")
                    ->wrapHeader()
                    ->getStateUsing(fn ($record) => "
                            <span class='font-semibold capitalize'>{$record->manufacturer}</span><br>
                            <span class='capitalize'>{$record->paint_color}</span>
                        ")
                    ->html()
                    ->wrap(),
                TextColumn::make('fuel_cylinders')
                    ->label("Fuel / Cylinders")
                    ->wrapHeader()
                    ->getStateUsing(fn ($record) => "
                            <span class='capitalize font-semibold'>{$record->fuel}</span><br>
                            <span>{$record->cylinders}</span>
                        ")
                    ->html()
                    ->wrap(),
                TextColumn::make('odometer')
                    ->numeric()
                    ->alignEnd(),
                TextColumn::make('transmission_drive')
                    ->label("Transmission / Drive")
                    ->wrapHeader()
                    ->getStateUsing(fn ($record) => "
                            <span class='capitalize'>{$record->transmission}</span><br>
                            <span class='uppercase font-semibold'>{$record->drive}</span>
                        ")
                    ->html()
                    ->wrap(),
                TextColumn::make('type')
                    ->extraAttributes(['class' => 'capitalize']),
                TextColumn::make('age')
                    ->alignEnd(),
                TextColumn::make('dataset_price')
                    ->label("Price")
                    ->money('USD')
                    ->alignEnd()
                    ->weight(FontWeight::SemiBold),
                TextColumn::make('rf')
                    ->label("RF")
                    ->getStateUsing(function ($record) {
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
                TextColumn::make('xgb')
                    ->label("XGB")
                    ->getStateUsing(function ($record) {
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
                TextColumn::make('lgbm')
                    ->label("LGBM")
                    ->getStateUsing(function ($record) {
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
                    ->button()
                    ->color('warning')
                    ->modalHeading('Calculation Detail')
                    ->modalContent(fn ($record) => view('filament.modals.view-calculation', [
                        'car' => $record,
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
            ])
            ->bulkActions([]);
    }

    public function render()
    {
        return view('livewire.example-table');
    }
}
