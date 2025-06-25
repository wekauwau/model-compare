<div {{ $attributes->merge(['class' => 'mt-5 p-2 border-2']) }}>
    <div {{ $heading->attributes->merge(['class' => 'mb-5 text-xl font-semibold']) }}>
        {{ $heading }}
    </div>
    <table class="text-lg">
        <tr>
            <td>AE</td>
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
                    |{{ number_format($actual, 2) }} − {{ number_format($predicted, 2) }}|
                </span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                <span class="font-semibold text-red-600">
                    {{ number_format($mae, 2) }}
                </span>
            </td>
        <tr>
            <td>APE</td>
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
                    |{{ number_format($actual, 2) }} − {{ number_format($predicted, 2) }}|
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
                <span class="font-semibold"><span class="text-red-600">{{ number_format($mapeStep1, 2) }}</span>
                    &divide;
                    {{ number_format($actual, 2) }}</span> &times;
                100%
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                <span class="font-semibold">{{ number_format($mapeStep2, 4) }} &times; 100%</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>=</td>
            <td>
                <span class="font-semibold text-purple-600">{{ number_format($mape, 2) }}%</span>
            </td>
        </tr>
    </table>
</div>
