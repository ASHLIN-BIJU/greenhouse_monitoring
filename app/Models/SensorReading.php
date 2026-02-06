<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    protected $fillable = [
    'user_id',
    'temperature',
    'humidity',
    'soil_moisture',
];

}
