<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GreenhousePlant extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['user_id', 'name', 'location', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'plant_id');
    }

    public function sensorLogs()
    {
        return $this->hasMany(SensorLog::class, 'plant_id');
    }

    public function chosenPlans()
    {
        return $this->hasMany(ChosenPlan::class, 'plant_id');
    }
}
