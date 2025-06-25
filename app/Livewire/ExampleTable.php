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
            ->query(Car::query()->with('predictedPrice'))
            ->striped()
            ->heading("Example From Dataset")
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
                TextColumn::make('predictedPrice.rf')
                    ->label("RF")
                    ->extraHeaderAttributes([
                        'class' => 'text-red-500',
                    ])
                    ->color('info'),
                TextColumn::make('predictedPrice.xgb')
                    ->label("XGB")
                    ->color('success'),
                TextColumn::make('predictedPrice.lgbm')
                    ->label("LGBM")
                    ->color('primary'),
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
