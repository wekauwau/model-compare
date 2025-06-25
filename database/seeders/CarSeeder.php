<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['wichita', 'toyota', '4', 'gas', 36610, 'automatic', 'rwd', 'pickup', 'white', 'ks', 2, true, 24950],
            ['birmingham', 'audi', '4', 'gas', 102380, 'automatic', '4wd', 'coupe', 'black', 'al', 10, true, 9000],
            ['fairbanks', 'jeep', '6', 'gas', 33000, 'automatic', '4wd', 'SUV', 'black', 'ak', 4, true, 26500],
            ['tucson', 'ford', '6', 'gas', 103000, 'automatic', 'rwd', 'pickup', 'white', 'az', 4, true, 24995],
            ['los angeles', 'bmw', '6', 'gas', 150684, 'automatic', 'rwd', 'sedan', 'white', 'ca', 8, true, 11999],
            ['denver', 'hyundai', '4', 'gas', 27695, 'automatic', 'fwd', 'sedan', 'black', 'co', 3, true, 17499],
            ['atlanta', 'mazda', '4', 'gas', 55490, 'manual', 'rwd', 'convertible', 'white', 'ga', 5, true, 18990],
            ['chicago', 'toyota', '6', 'gas', 87862, 'automatic', 'fwd', 'other', 'custom', 'il', 9, true, 13500],
            ['indianapolis', 'chevrolet', '8', 'gas', 43475, 'manual', 'rwd', 'convertible', 'silver', 'in', 16, true, 24900],
            ['winchester', 'volkswagen', '4', 'diesel', 83000, 'automatic', 'fwd', 'sedan', 'silver', 'va', 8, true, 10900],
        ];

        foreach ($data as $record) {
            Car::create([
                'region' => $record[0],
                'manufacturer' => $record[1],
                'cylinders' => $record[2],
                'fuel' => $record[3],
                'odometer' => $record[4],
                'transmission' => $record[5],
                'drive' => $record[6],
                'type' => $record[7],
                'paint_color' => $record[8],
                'state' => $record[9],
                'age' => $record[10],
                'from_dataset' => $record[11],
                'dataset_price' => $record[12],
            ]);
        }
    }
}
