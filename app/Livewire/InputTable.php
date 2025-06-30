<?php

namespace App\Livewire;

use App\Models\Car;
use App\Support\InputTableActions;
use App\Support\InputTableBulkActions;
use App\Support\InputTableColumns;
use App\Support\InputTableHeaderActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
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
            ->bulkActions(InputTableBulkActions::get())
            ->actions(InputTableActions::get());
    }

    public function render()
    {
        return view('livewire.input-table');
    }
}
