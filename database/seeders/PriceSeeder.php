<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [1000, 1000, 1000],
            [1000, 1000, 1000],
            [1000, 1000, 1000],
            [1000, 1000, 1000],
            [1000, 1000, 1000],
            [1000, 1000, 1000],
            [1000, 1000, 1000],
            [1000, 1000, 1000],
            [1000, 1000, 1000],
            [1000, 1000, 1000],
        ];

        $counter = 0;
        foreach ($data as $record) {
            Price::create([
                'car_id' => ++$counter,
                'rf' => $record[0],
                'xgb' => $record[1],
                'lgbm' => $record[2],
            ]);
        }
    }
}
