<?php

namespace App\Livewire;

use App\Models\Car;
use App\Support\InputTableActions;
use App\Support\InputTableColumns;
use App\Support\InputTableHeaderActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class InputTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    private function getQuery()
    {
        return Car::query()
            ->when(true, function ($query) {
                $query->where('from_dataset', false)->with('predictedPrice');
            })
            ->orderByDesc('id');
    }

    private function getBulkActions()
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
                ->modalCancelAction(false)
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getQuery())
            ->heading("Input Dari User")
            ->description("Harga dan prediksi harga ditampilkan dalam Dolar AS (USD).")
            ->striped()
            ->checkIfRecordIsSelectableUsing(fn (Car $record) => !is_null($record->dataset_price))
            ->columns(InputTableColumns::get())
            ->headerActions(InputTableHeaderActions::get())
            ->bulkActions($this->getBulkActions())
            ->actions(InputTableActions::get());
    }

    public function render()
    {
        return view('livewire.input-table');
    }
}
