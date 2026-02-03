<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PredefinedPlan extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'plan_type_id',
        'name',
        'min_temp',
        'max_temp',
        'min_humidity',
        'max_humidity',
        'min_soil_moisture',
        'max_soil_moisture'
    ];

    public function planType()
    {
        return $this->belongsTo(PlanType::class);
    }
}
