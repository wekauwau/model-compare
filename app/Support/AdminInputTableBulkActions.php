<?php

namespace App\Support;

use Filament\Tables\Actions\BulkAction;

class AdminInputTableBulkActions
{
    public static function get()
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
                ->modalCancelAction(false),
        ];
    }
}
