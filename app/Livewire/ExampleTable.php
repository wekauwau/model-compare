<?php

namespace App\Livewire;

use App\Models\Car;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
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
                TextColumn::make('region'),
                TextColumn::make('manufacturer'),
                TextColumn::make('cylinders'),
                TextColumn::make('fuel'),
                TextColumn::make('odometer')
                    ->numeric()
                    ->alignEnd(),
                TextColumn::make('transmission'),
                TextColumn::make('drive'),
                TextColumn::make('type'),
                TextColumn::make('paint_color'),
                TextColumn::make('state'),
                TextColumn::make('age'),
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
            ->actions([])
            ->bulkActions([]);
    }

    public function render()
    {
        return view('livewire.example-table');
    }
}
