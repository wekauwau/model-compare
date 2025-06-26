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
    $mape_rf_step_1 = '( ' . $mape_rf_errors->pluck('expression')->implode(' + ') . ' )';
    $mape_rf_step_2 = $mape_rf_errors->sum('value');
    $mape_rf_step_3 = $mape_rf_step_2 * 100;
    $mape_rf = number_format($mape_rf_step_3 / $n, 2);

    $mean_actual = $cars->avg('dataset_price');
    $r2_rf_left = collect($cars)->map(function ($car) {
        $actual = $car->dataset_price;
        $pred = $car->predictedPrice->rf ?? 0;

        return [
            'expression' => '(' . number_format($actual, 2) . ' - ' . number_format($pred, 2) . ')<sup>2</sup>',
            'value' => $actual - $pred,
        ];
    });
    $r2_rf_left_step_1 = '( ' . $r2_rf_left->pluck('expression')->implode(' + ') . ' )';
    $r2_rf_left_2 = collect($r2_rf_left->pluck('value'))->map(function ($val) {
        return [
            'expression' => '(' . number_format($val, 2) . ')<sup>2</sup>',
            'value' => $val ** 2,
        ];
    });
    $r2_rf_left_step_2 = '(' . $r2_rf_left_2->pluck('expression')->implode(' + ') . ')';
    $r2_rf_left_3 = collect($r2_rf_left_2->pluck('value'))->map(function ($val) {
        return [
            'expression' => number_format($val, 2),
            'value' => $val,
        ];
    });
    $r2_rf_left_step_3 = '(' . $r2_rf_left_3->pluck('expression')->implode(' + ') . ')';
    $r2_rf_left_step_4 = $r2_rf_left_3->sum('value');
    $r2_rf_right = collect($cars)->map(function ($car) use ($mean_actual) {
        $actual = $car->dataset_price;

        return [
            'expression' => '(' . number_format($actual, 2) . ' - ' . number_format($mean_actual, 2) . ')<sup>2</sup>',
            'value' => $actual - $mean_actual,
        ];
    });
    $r2_rf_right_step_1 = '( ' . $r2_rf_right->pluck('expression')->implode(' + ') . ' )';
    $r2_rf_right_2 = collect($r2_rf_right->pluck('value'))->map(function ($val) {
        return [
            'expression' => '(' . number_format($val, 2) . ')<sup>2</sup>',
            'value' => $val ** 2,
        ];
    });
    $r2_rf_right_step_2 = '( ' . $r2_rf_right_2->pluck('expression')->implode(' + ') . ' )';
    $r2_rf_right_3 = collect($r2_rf_right_2->pluck('value'))->map(function ($val) {
        return [
            'expression' => number_format($val, 2),
            'value' => $val,
        ];
    });
    $r2_rf_right_step_3 = '(' . $r2_rf_right_3->pluck('expression')->implode(' + ') . ')';
    $r2_rf_right_step_4 = $r2_rf_right_3->sum('value');
    $r2_rf_left_right = $r2_rf_left_step_4 / $r2_rf_right_step_4;
    $r2_rf = 1 - $r2_rf_left_right;

    $errors_xgb = collect($cars)->map(function ($car) {
        $actual = $car->dataset_price;
        $pred = $car->predictedPrice->xgb ?? 0; // null-safe

        return [
            'expression' => '|' . number_format($actual, 2) . ' - ' . number_format($pred, 2) . '|',
            'value' => abs($actual - $pred),
        ];
    });
    $mae_xgb_step_1 = '( ' . $errors_xgb->pluck('expression')->implode(' + ') . ' )';
    $mae_xgb_step_2 = $errors_xgb->sum('value');
    $mae_xgb = number_format($mae_xgb_step_2 / $n, 2);

    $mape_xgb_errors = collect($cars)->map(function ($car) {
        $actual = $car->dataset_price;
        $pred = $car->predictedPrice->xgb ?? 0;

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
    $mape_xgb_step_1 = '( ' . $mape_xgb_errors->pluck('expression')->implode(' + ') . ' )';
    $mape_xgb_step_2 = $mape_xgb_errors->sum('value');
    $mape_xgb_step_3 = $mape_xgb_step_2 * 100;
    $mape_xgb = number_format($mape_xgb_step_3 / $n, 2);

    $mean_actual = $cars->avg('dataset_price');
    $r2_xgb_left = collect($cars)->map(function ($car) {
        $actual = $car->dataset_price;
        $pred = $car->predictedPrice->xgb ?? 0;

        return [
            'expression' => '(' . number_format($actual, 2) . ' - ' . number_format($pred, 2) . ')<sup>2</sup>',
            'value' => $actual - $pred,
        ];
    });
    $r2_xgb_left_step_1 = '( ' . $r2_xgb_left->pluck('expression')->implode(' + ') . ' )';
    $r2_xgb_left_2 = collect($r2_xgb_left->pluck('value'))->map(function ($val) {
        return [
            'expression' => '(' . number_format($val, 2) . ')<sup>2</sup>',
            'value' => $val ** 2,
        ];
    });
    $r2_xgb_left_step_2 = '(' . $r2_xgb_left_2->pluck('expression')->implode(' + ') . ')';
    $r2_xgb_left_3 = collect($r2_xgb_left_2->pluck('value'))->map(function ($val) {
        return [
            'expression' => number_format($val, 2),
            'value' => $val,
        ];
    });
    $r2_xgb_left_step_3 = '(' . $r2_xgb_left_3->pluck('expression')->implode(' + ') . ')';
    $r2_xgb_left_step_4 = $r2_xgb_left_3->sum('value');
    $r2_xgb_right = collect($cars)->map(function ($car) use ($mean_actual) {
        $actual = $car->dataset_price;

        return [
            'expression' => '(' . number_format($actual, 2) . ' - ' . number_format($mean_actual, 2) . ')<sup>2</sup>',
            'value' => $actual - $mean_actual,
        ];
    });
    $r2_xgb_right_step_1 = '( ' . $r2_xgb_right->pluck('expression')->implode(' + ') . ' )';
    $r2_xgb_right_2 = collect($r2_xgb_right->pluck('value'))->map(function ($val) {
        return [
            'expression' => '(' . number_format($val, 2) . ')<sup>2</sup>',
            'value' => $val ** 2,
        ];
    });
    $r2_xgb_right_step_2 = '( ' . $r2_xgb_right_2->pluck('expression')->implode(' + ') . ' )';
    $r2_xgb_right_3 = collect($r2_xgb_right_2->pluck('value'))->map(function ($val) {
        return [
            'expression' => number_format($val, 2),
            'value' => $val,
        ];
    });
    $r2_xgb_right_step_3 = '(' . $r2_xgb_right_3->pluck('expression')->implode(' + ') . ')';
    $r2_xgb_right_step_4 = $r2_xgb_right_3->sum('value');
    $r2_xgb_left_right = $r2_xgb_left_step_4 / $r2_xgb_right_step_4;
    $r2_xgb = 1 - $r2_xgb_left_right;

    $errors_lgbm = collect($cars)->map(function ($car) {
        $actual = $car->dataset_price;
        $pred = $car->predictedPrice->lgbm ?? 0; // null-safe

        return [
            'expression' => '|' . number_format($actual, 2) . ' - ' . number_format($pred, 2) . '|',
            'value' => abs($actual - $pred),
        ];
    });
    $mae_lgbm_step_1 = '( ' . $errors_lgbm->pluck('expression')->implode(' + ') . ' )';
    $mae_lgbm_step_2 = $errors_lgbm->sum('value');
    $mae_lgbm = number_format($mae_lgbm_step_2 / $n, 2);

    $mape_lgbm_errors = collect($cars)->map(function ($car) {
        $actual = $car->dataset_price;
        $pred = $car->predictedPrice->lgbm ?? 0;

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
    $mape_lgbm_step_1 = '( ' . $mape_lgbm_errors->pluck('expression')->implode(' + ') . ' )';
    $mape_lgbm_step_2 = $mape_lgbm_errors->sum('value');
    $mape_lgbm_step_3 = $mape_lgbm_step_2 * 100;
    $mape_lgbm = number_format($mape_lgbm_step_3 / $n, 2);

    $mean_actual = $cars->avg('dataset_price');
    $r2_lgbm_left = collect($cars)->map(function ($car) {
        $actual = $car->dataset_price;
        $pred = $car->predictedPrice->lgbm ?? 0;

        return [
            'expression' => '(' . number_format($actual, 2) . ' - ' . number_format($pred, 2) . ')<sup>2</sup>',
            'value' => $actual - $pred,
        ];
    });
    $r2_lgbm_left_step_1 = '( ' . $r2_lgbm_left->pluck('expression')->implode(' + ') . ' )';
    $r2_lgbm_left_2 = collect($r2_lgbm_left->pluck('value'))->map(function ($val) {
        return [
            'expression' => '(' . number_format($val, 2) . ')<sup>2</sup>',
            'value' => $val ** 2,
        ];
    });
    $r2_lgbm_left_step_2 = '(' . $r2_lgbm_left_2->pluck('expression')->implode(' + ') . ')';
    $r2_lgbm_left_3 = collect($r2_lgbm_left_2->pluck('value'))->map(function ($val) {
        return [
            'expression' => number_format($val, 2),
            'value' => $val,
        ];
    });
    $r2_lgbm_left_step_3 = '(' . $r2_lgbm_left_3->pluck('expression')->implode(' + ') . ')';
    $r2_lgbm_left_step_4 = $r2_lgbm_left_3->sum('value');
    $r2_lgbm_right = collect($cars)->map(function ($car) use ($mean_actual) {
        $actual = $car->dataset_price;

        return [
            'expression' => '(' . number_format($actual, 2) . ' - ' . number_format($mean_actual, 2) . ')<sup>2</sup>',
            'value' => $actual - $mean_actual,
        ];
    });
    $r2_lgbm_right_step_1 = '( ' . $r2_lgbm_right->pluck('expression')->implode(' + ') . ' )';
    $r2_lgbm_right_2 = collect($r2_lgbm_right->pluck('value'))->map(function ($val) {
        return [
            'expression' => '(' . number_format($val, 2) . ')<sup>2</sup>',
            'value' => $val ** 2,
        ];
    });
    $r2_lgbm_right_step_2 = '( ' . $r2_lgbm_right_2->pluck('expression')->implode(' + ') . ' )';
    $r2_lgbm_right_3 = collect($r2_lgbm_right_2->pluck('value'))->map(function ($val) {
        return [
            'expression' => number_format($val, 2),
            'value' => $val,
        ];
    });
    $r2_lgbm_right_step_3 = '(' . $r2_lgbm_right_3->pluck('expression')->implode(' + ') . ')';
    $r2_lgbm_right_step_4 = $r2_lgbm_right_3->sum('value');
    $r2_lgbm_left_right = $r2_lgbm_left_step_4 / $r2_lgbm_right_step_4;
    $r2_lgbm = 1 - $r2_lgbm_left_right;
@endphp

<div>
    <table>
        <tr>
            <td>
                <span class="text-xl font-semibold">y<sub>i</sub></span>
            </td>
            <td>=</td>
            <td>
                Actual price
            </td>
        </tr>
        <tr>
            <td>
                <span class="text-xl font-semibold">ŷ<sub>i</sub></span>
            </td>
            <td>=</td>
            <td>
                Predicted price
            </td>
        </tr>
        <tr>
            <td>
                <span class="text-xl font-semibold">ȳ</span>
            </td>
            <td>=</td>
            <td>
                Mean of actual price
            </td>
        </tr>
    </table>

    <x-filament.modals.calculate.card :$n :mae_step_1="$mae_rf_step_1" :mae_step_2="$mae_rf_step_2" :mae="$mae_rf" :mape_step_1="$mape_rf_step_1"
        :mape_step_2="$mape_rf_step_2" :mape_step_3="$mape_rf_step_3" :mape="$mape_rf" :r2_left_step_1="$r2_rf_left_step_1" :r2_left_step_2="$r2_rf_left_step_2" :r2_left_step_3="$r2_rf_left_step_3"
        :r2_left_step_4="$r2_rf_left_step_4" :r2_right_step_1="$r2_rf_right_step_1" :r2_right_step_2="$r2_rf_right_step_2" :r2_right_step_3="$r2_rf_right_step_3" :r2_right_step_4="$r2_rf_right_step_4"
        :r2_left_right="$r2_rf_left_right" :r2="$r2_rf" class="bg-blue-50 border-blue-600">
        <x-slot:heading class="text-blue-600">
            Random Forest
        </x-slot>
    </x-filament.modals.calculate.card>

    <x-filament.modals.calculate.card :$n :mae_step_1="$mae_xgb_step_1" :mae_step_2="$mae_xgb_step_2" :mae="$mae_xgb" :mape_step_1="$mape_xgb_step_1"
        :mape_step_2="$mape_xgb_step_2" :mape_step_3="$mape_xgb_step_3" :mape="$mape_xgb" :r2_left_step_1="$r2_xgb_left_step_1" :r2_left_step_2="$r2_xgb_left_step_2"
        :r2_left_step_3="$r2_xgb_left_step_3" :r2_left_step_4="$r2_xgb_left_step_4" :r2_right_step_1="$r2_xgb_right_step_1" :r2_right_step_2="$r2_xgb_right_step_2" :r2_right_step_3="$r2_xgb_right_step_3"
        :r2_right_step_4="$r2_xgb_right_step_4" :r2_left_right="$r2_xgb_left_right" :r2="$r2_xgb" class="bg-green-50 border-green-600">
        <x-slot:heading class="text-green-600">
            XGBoost
        </x-slot>
    </x-filament.modals.calculate.card>

    <x-filament.modals.calculate.card :$n :mae_step_1="$mae_lgbm_step_1" :mae_step_2="$mae_lgbm_step_2" :mae="$mae_lgbm" :mape_step_1="$mape_lgbm_step_1"
        :mape_step_2="$mape_lgbm_step_2" :mape_step_3="$mape_lgbm_step_3" :mape="$mape_lgbm" :r2_left_step_1="$r2_lgbm_left_step_1" :r2_left_step_2="$r2_lgbm_left_step_2"
        :r2_left_step_3="$r2_lgbm_left_step_3" :r2_left_step_4="$r2_lgbm_left_step_4" :r2_right_step_1="$r2_lgbm_right_step_1" :r2_right_step_2="$r2_lgbm_right_step_2" :r2_right_step_3="$r2_lgbm_right_step_3"
        :r2_right_step_4="$r2_lgbm_right_step_4" :r2_left_right="$r2_lgbm_left_right" :r2="$r2_lgbm" class="bg-yellow-50 border-yellow-600">
        <x-slot:heading class="text-yellow-600">
            LightGBM
        </x-slot>
    </x-filament.modals.calculate.card>
</div>
