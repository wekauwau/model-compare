<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [1,'wichita', 'toyota', '4', 'gas', 36610, 'automatic', 'rwd', 'pickup', 'white', 'ks', 2, true, 24950],
            [1,'birmingham', 'audi', '4', 'gas', 102380, 'automatic', '4wd', 'coupe', 'black', 'al', 10, true, 9000],
            [1,'fairbanks', 'jeep', '6', 'gas', 33000, 'automatic', '4wd', 'SUV', 'black', 'ak', 4, true, 26500],
            [1,'tucson', 'ford', '6', 'gas', 103000, 'automatic', 'rwd', 'pickup', 'white', 'az', 4, true, 24995],
            [1,'los angeles', 'bmw', '6', 'gas', 150684, 'automatic', 'rwd', 'sedan', 'white', 'ca', 8, true, 11999],
            [1,'denver', 'hyundai', '4', 'gas', 27695, 'automatic', 'fwd', 'sedan', 'black', 'co', 3, true, 17499],
            [1,'atlanta', 'mazda', '4', 'gas', 55490, 'manual', 'rwd', 'convertible', 'white', 'ga', 5, true, 18990],
            [1,'chicago', 'toyota', '6', 'gas', 87862, 'automatic', 'fwd', 'other', 'custom', 'il', 9, true, 13500],
            [1,'indianapolis', 'chevrolet', '8', 'gas', 43475, 'manual', 'rwd', 'convertible', 'silver', 'in', 16, true, 24900],
            [1,'winchester', 'volkswagen', '4', 'diesel', 83000, 'automatic', 'fwd', 'sedan', 'silver', 'va', 8, true, 10900],
            [1,'jackson', 'ford', '8', 'gas', 121079, 'automatic', '4wd', 'truck', 'yellow', 'tn', 8, true, 19873],
            [1,'poconos', 'jeep', '4', 'gas', 86241, 'automatic', '4wd', 'SUV', 'black', 'pa', 5, true, 14995],
            [1,'mansfield', 'toyota', '4', 'gas', 49558, 'automatic', 'fwd', 'sedan', 'blue', 'oh', 4, true, 16995],
            [1,'portland', 'ford', '8', 'diesel', 169147, 'manual', '4wd', 'pickup', 'blue', 'or', 14, true, 14995],
            [1,'roseburg', 'toyota', '4', 'gas', 60423, 'automatic', 'fwd', 'sedan', 'blue', 'or', 5, true, 15990],

            [2,'chico', 'bmw', '8', 'hybrid', 5950, 'manual', 'rwd', 'sedan', 'white', 'il', 4, false, null],
            [3,'salina', 'rover', '4', 'diesel', 10500, 'manual', '4wd', 'offroad', 'black', 'ca', 7, false, null],
            [2,'shreveport', 'mercedes-benz', '4', 'gas', 3840, 'automatic', 'fwd', 'sedan', 'white', 'ga', 4, false, 22000],
            [3,'new orleans', 'buick', '12', 'electric', 6049, 'automatic', '4wd', 'coupe', 'purple', 'va', 6, false, 33900],
            [3,'kirksville', 'subaru', '8', 'gas', 7916, 'manual', 'fwd', 'sedan', 'black', 'md', 7, false, 19500],
            [2,'watertown', 'mercedes-benz', '4', 'gas', 10500, 'automatic', 'rwd', 'sedan', 'black', 'ri', 9, false, 15050],
            [2,'parkersburg-marietta', 'lexus', '8', 'gas', 10729, 'automatic', 'fwd', 'SUV', 'white', 'nd', 8, false, 25950],
            [3,'shreveport', 'kia', '4', 'electric', 14684, 'manual', '4wd', 'coupe', 'blue', 'mn', 7, false, null],
        ];

        foreach ($data as $record) {
            Car::create([
                'user_id' => $record[0],
                'region' => $record[1],
                'manufacturer' => $record[2],
                'cylinders' => $record[3],
                'fuel' => $record[4],
                'odometer' => $record[5],
                'transmission' => $record[6],
                'drive' => $record[7],
                'type' => $record[8],
                'paint_color' => $record[9],
                'state' => $record[10],
                'age' => $record[11],
                'from_dataset' => $record[12],
                'dataset_price' => $record[13],
            ]);
        }

        // Car::factory(20)->create();
    }
}
