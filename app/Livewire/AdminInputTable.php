<?php

namespace App\Livewire;

use App\Models\Car;
use App\Support\AdminInputTableActions;
use App\Support\AdminInputTableBulkActions;
use App\Support\AdminInputTableColumns;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class AdminInputTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    private function getQuery()
    {
        return Car::query()
            ->when(true, function ($query) {
                $query->where('from_dataset', false)->with('predictedPrice');
            })
            ->orderByDesc('car_id');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getQuery())
            ->heading("Input Dari User")
            ->description("Harga dan prediksi harga ditampilkan dalam Dolar AS (USD).")
            ->striped()
            ->columns(AdminInputTableColumns::get())
            ->bulkActions(AdminInputTableBulkActions::get())
            ->actions(AdminInputTableActions::get())
            ->filters([
                TernaryFilter::make('actualPrice')
                    ->label('Harga aktual')
                    ->placeholder('Semua data')
                    ->trueLabel('Data dengan harga aktual')
                    ->falseLabel('Data tanpa harga aktual')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('dataset_price'),
                        false: fn (Builder $query) => $query->whereNull('dataset_price'),
                        blank: fn (Builder $query) => $query,
                    )
            ]);
    }

    public function render()
    {
        return view('livewire.admin-input-table');
    }
}
