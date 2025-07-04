<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PredictedPrice extends Model
{
    protected $primaryKey = 'predicted_price_id';

    protected $fillable = [
        'car_id',
        'rf',
        'xgb',
        'lgbm',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id', 'car_id');
    }
}
