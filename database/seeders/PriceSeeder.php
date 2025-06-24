<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [1, 1000, 1000, 1000],
            [1, 1000, 1000, 1000],
            [1, 1000, 1000, 1000],
            [1, 1000, 1000, 1000],
            [1, 1000, 1000, 1000],
            [1, 1000, 1000, 1000],
            [1, 1000, 1000, 1000],
            [1, 1000, 1000, 1000],
            [1, 1000, 1000, 1000],
            [1, 1000, 1000, 1000],
        ];

        foreach ($data as $record) {
            Price::create([
                'car_id' => $record[0],
                'rf' => $record[1],
                'xgb' => $record[2],
                'lgbm' => $record[3],
            ]);
        }
    }
}
