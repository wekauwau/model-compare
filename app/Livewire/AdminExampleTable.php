<?php

namespace App\Livewire;

use App\Models\Car;
use App\Support\AdminExampleTableActions;
use App\Support\AdminExampleTableBulkActions;
use App\Support\AdminExampleTableColumns;
use App\Support\AdminExampleTableHeaderActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class AdminExampleTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    private function getQuery()
    {
        return Car::query()
            ->when(true, function ($query) {
                $query->where('from_dataset', true)->with('predictedPrice');
            })
            ->orderByDesc('car_id');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getQuery())
            ->heading("Sampel dari dataset")
            ->description("Harga dan prediksi harga ditampilkan dalam Dolar AS (USD).")
            ->striped()
            ->columns(AdminExampleTableColumns::get())
            ->headerActions(AdminExampleTableHeaderActions::get())
            ->bulkActions(AdminExampleTableBulkActions::get())
            ->actions(AdminExampleTableActions::get());
    }

    public function render()
    {
        return view('livewire.example-table');
    }
}
