<?php

namespace App\Support;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\RawJs;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;

class AdminInputTableActions
{
    public static function get()
    {
        return [
            ActionGroup::make([
                Action::make('viewCalculation')
                    ->button()
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading('Detail Perhitungan')
                    ->modalContent(fn ($record) => view('filament.modals.view-calculation', [
                        'car' => $record,
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->visible(fn ($record) => !is_null($record->dataset_price)),
            ])
            ->color('primary')
            ->dropdownWidth(MaxWidth::ExtraSmall)
        ];
    }

    private static function getEditForm()
    {
        return [
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
        ];
    }
}
