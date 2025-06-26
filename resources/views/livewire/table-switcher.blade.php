<div>
    {{-- Switch Buttons --}}
    <div class="flex justify-end mb-4 space-x-2">
        <button wire:click="setMode('sample')"
            class="px-4 py-2 border rounded {{ $mode === 'sample' ? 'bg-blue-600 text-white' : 'bg-white' }}">
            Sample
        </button>
        <button wire:click="setMode('input')"
            class="px-4 py-2 border rounded {{ $mode === 'input' ? 'bg-blue-600 text-white' : 'bg-white' }}">
            Input
        </button>
    </div>

    {{-- Dynamic Component --}}
    @if ($mode === 'sample')
        @livewire('example-table')
    @else
        @livewire('input-table')
    @endif
</div>
