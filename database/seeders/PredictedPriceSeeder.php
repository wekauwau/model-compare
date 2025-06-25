<?php

namespace Database\Seeders;

use App\Models\PredictedPrice;
use Illuminate\Database\Seeder;

class PredictedPriceSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [24950, 24741.35, 26392.61, 27668.46],
        ];

        $counter = 0;
        foreach ($data as $record) {
            PredictedPrice::create([
                'car_id' => ++$counter,
                'rf' => $record[0],
                'xgb' => $record[1],
                'lgbm' => $record[2],
            ]);
        }
    }
}
