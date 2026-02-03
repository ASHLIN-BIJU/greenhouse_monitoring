<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChosenPlan extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'plant_id',
        'plan_type_id',
        'name',
        'min_temp',
        'max_temp',
        'min_humidity',
        'max_humidity',
        'min_soil_moisture',
        'max_soil_moisture',
        'is_active'
    ];

    public function plant()
    {
        return $this->belongsTo(GreenhousePlant::class, 'plant_id');
    }

    public function planType()
    {
        return $this->belongsTo(PlanType::class);
    }
}
