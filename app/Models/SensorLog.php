<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorLog extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['plant_id', 'temperature', 'humidity', 'soil_moisture', 'recorded_at'];

    public function plant()
    {
        return $this->belongsTo(GreenhousePlant::class, 'plant_id');
    }
}
