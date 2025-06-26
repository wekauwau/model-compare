<?php

namespace App\Livewire;

use Livewire\Component;

class TableSwitcher extends Component
{
    public string $mode = 'sample';

    public function setMode($value)
    {
        $this->mode = $value;
    }

    public function render()
    {
        return view('livewire.table-switcher');
    }
}
