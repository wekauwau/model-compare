<h1 class="text-2xl font-bold mb-6 text-gray-800">Model Prediction Comparison</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Repeat for each model -->
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold text-blue-600 mb-2">Random Forest</h2>
        <ul class="space-y-1 text-gray-700">
            <li><span class="font-medium">MAE:</span> 1,772.55</li>
            <li><span class="font-medium">R²:</span> 0.92</li>
            <li><span class="font-medium">MAPE:</span> 16.20%</li>
            <li><span class="font-medium">Training Time:</span> 3.2s</li>
        </ul>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">XGBoost</h2>
        <ul class="space-y-1 text-gray-700">
            <li><span class="font-medium">MAE:</span> 1,834.22</li>
            <li><span class="font-medium">R²:</span> 0.91</li>
            <li><span class="font-medium">MAPE:</span> 17.03%</li>
            <li><span class="font-medium">Training Time:</span> 1.7s</li>
        </ul>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold text-yellow-600 mb-2">LightGBM</h2>
        <ul class="space-y-1 text-gray-700">
            <li><span class="font-medium">MAE:</span> 1,844.61</li>
            <li><span class="font-medium">R²:</span> 0.90</li>
            <li><span class="font-medium">MAPE:</span> 17.80%</li>
            <li><span class="font-medium">Training Time:</span> 1.5s</li>
        </ul>
    </div>
</div>
