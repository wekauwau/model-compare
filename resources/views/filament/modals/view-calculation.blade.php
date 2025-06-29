@php
    $actual = $car->dataset_price;

    $predicted_rf = $car->predictedPrice->rf;
    $mae_rf = abs($actual - $predicted_rf);
    $mape_rf_step_1 = $mae_rf;
    $mape_rf_step_2 = $mape_rf_step_1 / $actual;
    $mape_rf = $mape_rf_step_2 * 100;

    $predicted_xgb = $car->predictedPrice->xgb;
    $mae_xgb = abs($actual - $predicted_xgb);
    $mape_xgb_step_1 = $mae_xgb;
    $mape_xgb_step_2 = $mape_xgb_step_1 / $actual;
    $mape_xgb = $mape_xgb_step_2 * 100;

    $predicted_lgbm = $car->predictedPrice->lgbm;
    $mae_lgbm = abs($actual - $predicted_lgbm);
    $mape_lgbm_step_1 = $mae_lgbm;
    $mape_lgbm_step_2 = $mape_lgbm_step_1 / $actual;
    $mape_lgbm = $mape_lgbm_step_2 * 100;
@endphp

<div>
    <table>
        <tr>
            <td>
                <span class="text-xl font-semibold leading-none">y<sub>i</sub></span>
            </td>
            <td class="px-1">=</td>
            <td>
                Harga aktual
            </td>
        </tr>
        <tr>
            <td>
                <span class="text-xl font-semibold leading-none">ŷ<sub>i</sub></span>
            </td>
            <td class="px-1">=</td>
            <td>
                Harga prediksi
            </td>
        </tr>
    </table>

    <x-filament.modals.view-calculation.card :$actual :predicted="$predicted_rf" :mae="$mae_rf" :mape-step-1="$mae_rf"
        :mape_step_2="$mape_rf_step_2" :mape="$mape_rf" class="bg-blue-50 border-blue-600">
        <x-slot:heading class="text-blue-600">
            Random Forest
        </x-slot>
    </x-filament.modals.view-calculation.card>
    <x-filament.modals.view-calculation.card :$actual :predicted="$predicted_xgb" :mae="$mae_xgb" :mape-step-1="$mae_xgb"
        :mape_step_2="$mape_xgb_step_2" :mape="$mape_xgb" class="bg-green-50 border-green-600">
        <x-slot:heading class="text-green-600">
            XGBoost
        </x-slot>
    </x-filament.modals.view-calculation.card>
    <x-filament.modals.view-calculation.card :$actual :predicted="$predicted_lgbm" :mae="$mae_lgbm" :mape-step-1="$mae_lgbm"
        :mape_step_2="$mape_lgbm_step_2" :mape="$mape_lgbm" class="bg-yellow-50 border-yellow-600">
        <x-slot:heading class="text-yellow-600">
            LightGBM
        </x-slot>
    </x-filament.modals.view-calculation.card>
</div>
