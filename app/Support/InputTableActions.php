<?php

namespace App\Support;

use Filament\Tables\Actions\Action;

class InputTableActions
{
    public static function get()
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
}
