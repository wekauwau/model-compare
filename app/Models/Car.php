<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $primaryKey = 'car_id';

    protected $fillable = [
        'region',
        'manufacturer',
        'cylinders',
        'fuel',
        'odometer',
        'transmission',
        'drive',
        'type',
        'paint_color',
        'state',
        'age',
        'from_dataset',
        'dataset_price',
    ];

    public function predictedPrice()
    {
        return $this->hasOne(PredictedPrice::class, 'car_id', 'car_id');
    }
}
