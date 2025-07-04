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
            ['jackson', 'ford', '8', 'gas', 121079, 'automatic', '4wd', 'truck', 'yellow', 'tn', 8, true, 19873],
            ['poconos', 'jeep', '4', 'gas', 86241, 'automatic', '4wd', 'SUV', 'black', 'pa', 5, true, 14995],
            ['mansfield', 'toyota', '4', 'gas', 49558, 'automatic', 'fwd', 'sedan', 'blue', 'oh', 4, true, 16995],
            ['portland', 'ford', '8', 'diesel', 169147, 'manual', '4wd', 'pickup', 'blue', 'or', 14, true, 14995],
            ['roseburg', 'toyota', '4', 'gas', 60423, 'automatic', 'fwd', 'sedan', 'blue', 'or', 5, true, 15990],

            ['chico', 'bmw', '8', 'hybrid', 5950, 'manual', 'rwd', 'sedan', 'white', 'il', 4, false, null],
            ['salina', 'rover', '4', 'diesel', 10500, 'manual', '4wd', 'offroad', 'black', 'ca', 7, false, null],
            ['shreveport', 'mercedes-benz', '4', 'gas', 3840, 'automatic', 'fwd', 'sedan', 'white', 'ga', 4, false, 22000],
            ['new orleans', 'buick', '12', 'electric', 6049, 'automatic', '4wd', 'coupe', 'purple', 'va', 6, false, 33900],
            ['kirksville', 'subaru', '8', 'gas', 7916, 'manual', 'fwd', 'sedan', 'black', 'md', 7, false, null],
            ['watertown', 'mercedes-benz', '4', 'gas', 10500, 'automatic', 'rwd', 'sedan', 'black', 'ri', 9, false, 15050],
            ['parkersburg-marietta', 'lexus', '8', 'gas', 10729, 'automatic', 'fwd', 'SUV', 'white', 'nd', 8, false, 25950],
            ['shreveport', 'kia', '4', 'electric', 14684, 'manual', '4wd', 'coupe', 'blue', 'mn', 7, false, null],
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

        // Car::factory(20)->create();
    }
}
