<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
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
    ];
}
