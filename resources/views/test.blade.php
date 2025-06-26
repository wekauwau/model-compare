<x-layouts.app>
    <div class="p-6 bg-gray-100 min-h-screen">
        <x-model-cards />

        {{-- Page content inside the layout --}}
        <h1 class="text-2xl font-bold mb-4">Car Dashboard</h1>

        {{-- Livewire Table Switcher --}}
        @livewire('table-switcher')
</x-layouts.app>
