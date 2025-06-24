<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['wichita', 'toyota', '4', 'gas', 36610, 'automatic', 'rwd', 'pickup', 'white', 'ks', 2],
            ['birmingham', 'audi', '4', 'gas', 102380, 'automatic', '4wd', 'coupe', 'black', 'al', 10],
            ['fairbanks', 'jeep', '6', 'gas', 33000, 'automatic', '4wd', 'SUV', 'black', 'ak', 4],
            ['tucson', 'ford', '6', 'gas', 103000, 'automatic', 'rwd', 'pickup', 'white', 'az', 4],
            ['los angeles', 'bmw', '6', 'gas', 150684, 'automatic', 'rwd', 'sedan', 'white', 'ca', 8],
            ['denver', 'hyundai', '4', 'gas', 27695, 'automatic', 'fwd', 'sedan', 'black', 'co', 3],
            ['atlanta', 'mazda', '4', 'gas', 55490, 'manual', 'rwd', 'convertible', 'white', 'ga', 5],
            ['chicago', 'toyota', '6', 'gas', 87862, 'automatic', 'fwd', 'other', 'custom', 'il', 9],
            ['indianapolis', 'chevrolet', '8', 'gas', 43475, 'manual', 'rwd', 'convertible', 'silver', 'in', 16],
            ['winchester', 'volkswagen', '4', 'diesel', 83000, 'automatic', 'fwd', 'sedan', 'silver', 'va', 8],
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
            ]);
        }
    }
}
