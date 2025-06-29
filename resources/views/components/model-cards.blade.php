<h1 class="text-2xl font-bold mb-6 text-gray-800">Perbandingan Model Prediksi Harga Mobil Bekas</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-blue-50 border-2 border-blue-600 rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold text-blue-600 mb-2">Random Forest</h2>
        <table class="space-y-1 text-gray-700">
            <tr>
                <td><span class="font-medium">MAE</span></td>
                <td> : </td>
                <td><span class="font-semibold text-red-600">1,772.55</span></td>
            </tr>
            <tr>
                <td><span class="font-medium">MAPE</span></td>
                <td> : </td>
                <td><span class="font-semibold text-purple-600">16.20%</span></td>
            </tr>
            <tr>
                <td><span class="font-medium">R²</span></td>
                <td> : </td>
                <td><span class="font-semibold text-cyan-600">0.92</span></td>
            </tr>
            <tr>
                <td><span class="font-medium">Waktu Training</span></td>
                <td> : </td>
                <td><span class="font-semibold">28 menit</span></td>
            </tr>
        </table>
    </div>

    <div class="bg-green-50 border-2 border-green-600 rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold text-green-600 mb-2">XGBoost</h2>
        <table class="space-y-1 text-gray-700">
            <tr>
                <td><span class="font-medium">MAE</span></td>
                <td> : </td>
                <td><span class="font-semibold text-red-600">3,105.48</span></td>
            </tr>
            <tr>
                <td><span class="font-medium">MAPE</span></td>
                <td> : </td>
                <td><span class="font-semibold text-purple-600">25.14%</span></td>
            </tr>
            <tr>
                <td><span class="font-medium">R²</span></td>
                <td> : </td>
                <td><span class="font-semibold text-cyan-600">0.86</span></td>
            </tr>
            <tr>
                <td><span class="font-medium">Waktu Training</span></td>
                <td> : </td>
                <td><span class="font-semibold">27 detik</span></td>
            </tr>
        </table>
    </div>

    <div class="bg-yellow-50 border-2 border-yellow-600 rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold text-yellow-600 mb-2">LightGBM</h2>
        <table class="space-y-1 text-gray-700">
            <tr>
                <td><span class="font-medium">MAE</span></td>
                <td> : </td>
                <td><span class="font-semibold text-red-600">3,324.73</span></td>
            </tr>
            <tr>
                <td><span class="font-medium">MAPE</span></td>
                <td> : </td>
                <td><span class="font-semibold text-purple-600">26.72%</span></td>
            </tr>
            <tr>
                <td><span class="font-medium">R²</span></td>
                <td> : </td>
                <td><span class="font-semibold text-cyan-600">0.84</span></td>
            </tr>
            <tr>
                <td><span class="font-medium">Waktu Training</span></td>
                <td> : </td>
                <td><span class="font-semibold">9 detik</span></td>
            </tr>
        </table>
    </div>
</div>
