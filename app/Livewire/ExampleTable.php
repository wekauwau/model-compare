<?php

namespace App\Livewire;

use App\Models\Car;
use App\Support\ExampleTableBulkActions;
use App\Support\ExampleTableColumns;
use App\Support\ExampleTableHeaderActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ExampleTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    private function getQuery()
    {
        return Car::query()
            ->when(true, function ($query) {
                $query->where('from_dataset', true)->with('predictedPrice');
            })
            ->orderByDesc('id');
    }

    private function getActions()
    {
        return [
            Action::make('viewCalculation')
                ->label('Detail')
                ->button()
                ->color('warning')
                ->icon('heroicon-o-eye')
                ->modalHeading('Detail perhitungan')
                ->modalContent(fn ($record) => view('filament.modals.view-calculation', [
                    'car' => $record,
                ]))
                ->modalSubmitAction(false)
                ->modalCancelAction(false)
            ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getQuery())
            ->heading("Sampel dari dataset")
            ->description("Harga dan prediksi harga ditampilkan dalam Dolar AS (USD).")
            ->striped()
            ->columns(ExampleTableColumns::get())
            ->headerActions(ExampleTableHeaderActions::get())
            ->bulkActions(ExampleTableBulkActions::get())
            ->actions($this->getActions());
    }

    public function render()
    {
        return view('livewire.example-table');
    }
}
