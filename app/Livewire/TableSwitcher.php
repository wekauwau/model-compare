<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TableSwitcher extends Component
{
    public string $mode = 'input';

    public function mount()
    {
        // If user is logged in and type is admin, set default mode
        if (Auth::check() && Auth::user()->type === 'admin') {
            $this->mode = 'sample';
        }
    }

    public function setMode($value)
    {
        $this->mode = $value;
    }

    public function render()
    {
        return view('livewire.table-switcher');
    }
}
