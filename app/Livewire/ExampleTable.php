<?php

namespace App\Livewire;

use App\Models\Car;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
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
        ->query(Car::query()->with('price'))
            ->columns([
                TextColumn::make('region'),
                TextColumn::make('manufacturer'),
                TextColumn::make('cylinders'),
                TextColumn::make('fuel'),
                TextColumn::make('odometer'),
                TextColumn::make('transmission'),
                TextColumn::make('drive'),
                TextColumn::make('type'),
                TextColumn::make('paint_color'),
                TextColumn::make('state'),
                TextColumn::make('age'),
                TextColumn::make('price.rf')->label("RF"),
                TextColumn::make('price.xgb')->label("XGB"),
                TextColumn::make('price.lgbm')->label("LGBM"),
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
