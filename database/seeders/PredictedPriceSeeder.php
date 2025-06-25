<?php

namespace Database\Seeders;

use App\Models\PredictedPrice;
use Illuminate\Database\Seeder;

class PredictedPriceSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [24741.35, 26392.61, 27668.46],
            [9650.94, 11567.72, 10835.82],
            [26572.56, 31679.76, 31186.88],
            [25141.68, 27925.99, 25575.43],
            [11809.74, 11626.94, 10396.6],
            [17540.01, 17637.71, 18901.57],
            [19560.49, 19029.55, 19107.05],
            [13826.36, 15193.47, 16285.42],
            [25016.03, 25287.91, 24424.16],
            [10857.9, 8669.89,  7024.4],
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
