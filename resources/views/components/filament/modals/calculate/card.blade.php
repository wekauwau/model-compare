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
                (1 ÷ {{ $n }}) × <span class="font-semibold">{{ $maeStep1 }}</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                <span class="font-semibold">(1 ÷ {{ $n }}) × {{ number_format($maeStep2, 2) }}</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                <span class="font-semibold text-red-600">{{ $mae }}</span>
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
                (1 ÷ {{ $n }}) × <span class="font-semibold">{{ $mapeStep1 }}</span> × 100%
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                (1 ÷ {{ $n }}) × <span class="font-semibold">{{ number_format($mapeStep2, 4) }} ×
                    100%</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                <span class="font-semibold">(1 ÷ {{ $n }}) × {{ number_format($mapeStep3, 2) }}%</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                <span class="font-semibold text-purple-600">{{ $mape }}%</span>
            </td>
        </tr>
        <tr>
            <td>R²</td>
            <td>=</td>
            <td>
                1 - (Σ(y<sub>i</sub> − ŷ<sub>i</sub>)<sup>2</sup> ÷ Σ(y<sub>i</sub> − ȳ)<sup>2</sup>)
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                1 - (<span class="font-semibold">{!! $r2LeftStep1 !!}</span> ÷ Σ(y<sub>i</sub> − ȳ)<sup>2</sup>)
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                1 - (<span class="font-semibold">{!! $r2LeftStep2 !!}</span> ÷ Σ(y<sub>i</sub> − ȳ)<sup>2</sup>)
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                1 - (<span class="font-semibold">{{ $r2LeftStep3 }}</span> ÷ Σ(y<sub>i</sub> − ȳ)<sup>2</sup>)
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                1 - ({{ number_format($r2LeftStep4, 2) }} ÷ <span class="font-semibold">{!! $r2RightStep1 !!}</span>)
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                1 - ({{ number_format($r2LeftStep4, 2) }} ÷ <span class="font-semibold">{!! $r2RightStep2 !!}</span>)
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                1 - ({{ number_format($r2LeftStep4, 2) }} ÷ <span class="font-semibold">{{ $r2RightStep3 }}</span>)
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                1 - <span class="font-semibold">({{ number_format($r2LeftStep4, 2) }} ÷
                    {{ $r2RightStep4 }})</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                1 - <span class="font-semibold">{{ number_format($r2LeftRight, 4) }}</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                <span class="font-semibold text-cyan-600">{{ number_format($r2, 4) }}</span>
            </td>
        </tr>
    </table>
</div>
