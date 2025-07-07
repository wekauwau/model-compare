<?php

namespace App\Support;

use App\Models\Car;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;

class InputTableColumns
{
    public static function get()
    {
        return [
            TextColumn::make('region_state')
                ->label("Region / State")
                ->searchable(['region', 'state'])
                ->wrapHeader()
                ->getStateUsing(fn (Car $record) => "
                    <span class='capitalize'>{$record->region}</span><br>
                    <span class='font-semibold uppercase'>{$record->state}</span>
                ")
                ->html()
                ->wrap(),
            TextColumn::make('manufacturer_paint_color')
                ->label("Manufacturer / Paint Color")
                ->searchable(['manufacturer', 'paint_color'])
                ->wrapHeader()
                ->getStateUsing(fn (Car $record) => "
                    <span class='font-semibold capitalize'>{$record->manufacturer}</span><br>
                    <span class='capitalize'>{$record->paint_color}</span>
                ")
                ->html()
                ->wrap(),
            TextColumn::make('fuel_cylinders')
                ->label("Fuel / Cylinders")
                ->searchable(['fuel', 'cylinders'])
                ->wrapHeader()
                ->getStateUsing(fn (Car $record) => "
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
                ->getStateUsing(fn (Car $record) => "
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
                ->formatStateUsing(fn (string $state): string => '$' . number_format($state, 2))
                ->weight(FontWeight::SemiBold)
                ->alignEnd(),
            TextColumn::make('predictedPrice.rf')
                ->label("Prediksi 1")
                ->searchable()
                ->getStateUsing(function (Car $record) {
                    $predicted = number_format($record->predictedPrice->rf ?? 0, 2);

                    return <<<HTML
                        <div class='text-blue-600'>$$predicted</div>
                    HTML;
                })
                ->html()
                ->weight(FontWeight::SemiBold)
                ->alignEnd(),
            TextColumn::make('predictedPrice.xgb')
                ->label("Prediksi 2")
                ->searchable()
                ->getStateUsing(function (Car $record) {
                    $predicted = number_format($record->predictedPrice->xgb ?? 0, 2);

                    return <<<HTML
                        <div class='text-green-600'>$$predicted</div>
                    HTML;
                })
                ->html()
                ->weight(FontWeight::SemiBold)
                ->alignEnd(),
            TextColumn::make('predictedPrice.lgbm')
                ->label("Prediksi 3")
                ->searchable()
                ->getStateUsing(function (Car $record) {
                    $predicted = number_format($record->predictedPrice->lgbm ?? 0, 2);

                    return <<<HTML
                        <div class='text-yellow-600'>$$predicted</div>
                    HTML;
                })
                ->html()
                ->weight(FontWeight::SemiBold)
                ->alignEnd(),
        ];
    }
}
