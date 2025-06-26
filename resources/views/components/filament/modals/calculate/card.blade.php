@php
    $n = $cars->count();

    $errors = collect($cars)->map(function ($car) {
        $actual = $car->dataset_price;
        $pred = $car->predictedPrice->rf ?? 0; // null-safe
        return [
            'expression' => '|' . number_format($actual, 2) . ' - ' . number_format($pred, 2) . '|',
            'value' => abs($actual - $pred),
        ];
    });

    $expressionString = '( ' . $errors->pluck('expression')->implode(' + ') . ' )';
    $totalError = $errors->sum('value');
    $mae = number_format($totalError / $n, 2);
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
                (1 ÷ {{ $n }}) × <span class="font-semibold">{{ $expressionString }}</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                <span class="font-semibold">(1 ÷ {{ $n }}) × {{ $totalError }}</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                <span class="font-semibold text-red-600">{{ $mae }}</span>
            </td>
        </tr>
    </table>
</div>
