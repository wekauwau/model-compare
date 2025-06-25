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

    <x-filament.modals.view-calculation.card title="Random Forest" :$actual :predicted="$predicted_rf" :mae="$mae_rf"
        :mape-step-1="$mae_rf" :mape_step_2="$mape_rf_step_2" :mape="$mape_rf" class="bg-blue-50" />
</div>
