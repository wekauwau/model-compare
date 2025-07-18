<div>
    <div class="flex justify-center mt-10 mb-6 space-x-2">

        @if (auth()->check())
            @if (auth()->user()->type === 'admin')
                <button wire:click="setMode('input')"
                    class="px-4 py-2 border-2 rounded-lg hover:bg-blue-500 hover:border-blue-500 hover:text-white {{ $mode === 'input' ? 'bg-blue-500 border-blue-500 text-white' : 'bg-white border-gray-400 ' }}">
                    Input
                </button>
                <button wire:click="setMode('sample')"
                    class="px-4 py-2 border-2 rounded-lg hover:bg-blue-500 hover:border-blue-500 hover:text-white {{ $mode === 'sample' ? 'bg-blue-500 border-blue-500 text-white' : 'bg-white border-gray-400 ' }}">
                    Sampel
                </button>
    </div>

    @if ($mode === 'input')
        @livewire('admin-input-table')
    @else
        @livewire('admin-example-table')
    @endif
@elseif (auth()->user()->type === 'user')
    @if ($mode === 'input')
        @livewire('input-table')
    @else
        @livewire('example-table')
    @endif
    @endif
    @endif
</div>
