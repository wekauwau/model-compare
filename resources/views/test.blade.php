<x-layouts.app>
    <div class="p-6 bg-gray-100 min-h-screen">
        <x-model-cards />

        @livewire('example-table')

        <div class="mt-10">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Sample Prediction Results</h2>
            <div class="overflow-x-auto bg-white rounded-2xl shadow">
                <table class="min-w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-200 uppercase text-xs text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Car</th>
                            <th class="px-4 py-3">Actual Price</th>
                            <th class="px-4 py-3">RF Prediction</th>
                            <th class="px-4 py-3">XGB Prediction</th>
                            <th class="px-4 py-3">LGBM Prediction</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="px-4 py-2">Toyota Camry 2016</td>
                            <td class="px-4 py-2">$15,000</td>
                            <td class="px-4 py-2 text-blue-600">$14,800</td>
                            <td class="px-4 py-2 text-green-600">$15,200</td>
                            <td class="px-4 py-2 text-yellow-600">$14,900</td>
                        </tr>
                        <!-- More rows -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
