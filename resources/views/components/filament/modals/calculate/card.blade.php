@php
    $n = $cars->count();

    $errors_rf = collect($cars)->map(function ($car) {
        $actual = $car->dataset_price;
        $pred = $car->predictedPrice->rf ?? 0; // null-safe
        return [
            'expression' => '|' . number_format($actual, 2) . ' - ' . number_format($pred, 2) . '|',
            'value' => abs($actual - $pred),
        ];
    });

    $mae_rf_step_1 = '( ' . $errors_rf->pluck('expression')->implode(' + ') . ' )';
    $mae_rf_step_2 = $errors_rf->sum('value');
    $mae_rf = number_format($mae_rf_step_2 / $n, 2);

    $mape_rf_details = collect($cars)->map(function ($car) {
        $actual = $car->dataset_price;
        $pred = $car->predictedPrice->rf ?? 0;

        // Avoid division by zero
        if ($actual == 0) {
            return [
                'expression' => '|0 - ' . number_format($pred, 2) . '| / 0',
                'value' => 0,
            ];
        }

        $percentage_error = (abs($actual - $pred) / $actual) * 100;

        return [
            'expression' =>
                '(|' .
                number_format($actual, 2) .
                ' - ' .
                number_format($pred, 2) .
                '| / ' .
                number_format($actual, 2) .
                ')',
            'value' => $percentage_error,
        ];
    });

    $mape_rf_errors = collect($cars)->map(function ($car) {
        $actual = $car->dataset_price;
        $pred = $car->predictedPrice->rf ?? 0;

        // Avoid division by zero
        if ($actual == 0) {
            return [
                'expression' => '|0 - ' . number_format($pred, 2) . '| / 0',
                'value' => 0,
            ];
        }

        $errors = abs($actual - $pred) / $actual;

        return [
            'expression' =>
                '(|' .
                number_format($actual, 2) .
                ' - ' .
                number_format($pred, 2) .
                '| / ' .
                number_format($actual, 2) .
                ')',
            'value' => $errors,
        ];
    });

    $mape_rf_step_1 = '( ' . $mape_rf_details->pluck('expression')->implode(' + ') . ' )';
    $mape_rf_step_2 = $mape_rf_errors->sum('value');
    $mape_rf_step_3 = $mape_rf_step_2 * 100;
    $mape_rf = number_format($mape_rf_step_3 / $n, 2);
@endphp

<div {{ $attributes->merge(['class' => 'mt-5 p-2 border-2']) }}>
    <div {{ $heading->attributes->merge(['class' => 'mb-5 text-xl font-semibold']) }}>
        {{ $heading }}
    </div>
    <table class="text-lg align-top">
        <tr>
            <td>MAE</td>
            <td>=</td>
            <td>
                (1 ÷ n) × Σ(i=1 to n) |y<sub>i</sub> − ŷ<sub>i</sub>|
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                (1 ÷ {{ $n }}) × <span class="font-semibold">{{ $mae_rf_step_1 }}</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                <span class="font-semibold">(1 ÷ {{ $n }}) × {{ number_format($mae_rf_step_2, 2) }}</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                <span class="font-semibold text-red-600">{{ $mae_rf }}</span>
            </td>
        </tr>
        <tr>
            <td>MAPE</td>
            <td>=</td>
            <td>
                (1 ÷ n) × Σ(i=1 to n) |(y<sub>i</sub> − ŷ<sub>i</sub>) ÷ y<sub>i</sub>| × 100%
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                (1 ÷ {{ $n }}) × <span class="font-semibold">{{ $mape_rf_step_1 }}</span> × 100%
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                (1 ÷ {{ $n }}) × <span class="font-semibold">{{ number_format($mape_rf_step_2, 4) }} ×
                    100%</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                <span class="font-semibold">(1 ÷ {{ $n }}) × {{ number_format($mape_rf_step_3, 2) }}%</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                <span class="font-semibold text-purple-600">{{ $mape_rf }}%</span>
            </td>
        </tr>
    </table>
</div>
