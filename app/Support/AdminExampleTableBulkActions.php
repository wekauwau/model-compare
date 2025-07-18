<?php

namespace App\Support;

use App\Models\PredictedPrice;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DeleteBulkAction;

class AdminExampleTableBulkActions
{
    public static function get()
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
                ->modalCancelAction(false),
            DeleteBulkAction::make()
                ->modalHeading("Hapus Data yang Dipilih")
                ->modalDescription("Apakah Anda yakin?")
                ->modalSubmitActionLabel("Ya, hapus")
                ->before(function (DeleteBulkAction $action) {
                    $car_ids = $action->getRecords()->pluck('id');

                    foreach ($car_ids as $car_id) {
                        PredictedPrice::where('car_id', $car_id)->delete();
                        // $car = Car::findOrFail($car_id);
                        // $car->predictedPrice()?->delete();
                    }
                })
            ];
    }
}
