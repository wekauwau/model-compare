@php
    $actual = $car->dataset_price;
    $predicted_rf = $car->predictedPrice->rf;

    $mae_rf = abs($actual - $predicted_rf);
    $mape_rf_step_1 = $mae_rf;
    $mape_rf_step_2 = $mape_rf_step_1 / $actual;
    $mape_rf = $mape_rf_step_2 * 100;
@endphp

<div>
    <div>A = Actual price</div>
    <div>P = Predicted price</div>

    <div class="mt-5 p-2 bg-blue-50">
        <div class="mb-5 text-xl font-semibold text-blue-600">Random Forest</div>
        <table class="text-lg">
            <tr>
                <td>MAE</td>
                <td>=</td>
                <td>
                    |A − P|
                </td>
            </tr>
            <tr>
                <td></td>
                <td>=</td>
                <td>
                    <span class="font-semibold">
                        |{{ number_format($actual, 2) }} − {{ number_format($predicted_rf, 2) }}|
                    </span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>=</td>
                <td>
                    <span class="font-semibold text-red-600">
                        {{ number_format($mae_rf, 2) }}
                    </span>
                </td>
            <tr>
                <td>MAPE</td>
                <td>=</td>
                <td>
                    |A − P| &divide; A &times; 100%
                </td>
            </tr>
            <tr>
                <td></td>
                <td>=</td>
                <td>
                    <span class="font-semibold">
                        |{{ number_format($actual, 2) }} − {{ number_format($predicted_rf, 2) }}|
                    </span>
                    &divide;
                    {{ number_format($actual, 2) }}
                    &times;
                    100%
                </td>
            </tr>
            <tr>
                <td></td>
                <td>=</td>
                <td>
                    <span class="font-semibold"><span class="text-red-600">{{ number_format($mape_rf_step_1, 2) }}</span>
                        &divide;
                        {{ number_format($actual, 2) }}</span> &times;
                    100%
                </td>
            </tr>
            <tr>
                <td></td>
                <td>=</td>
                <td>
                    <span class="font-semibold">{{ number_format($mape_rf_step_2, 4) }} &times; 100%</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>=</td>
                <td>
                    <span class="font-semibold text-purple-600">{{ number_format($mape_rf, 2) }}%</span>
                </td>
            </tr>
        </table>
    </div>
</div>
