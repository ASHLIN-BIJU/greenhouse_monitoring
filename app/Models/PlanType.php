<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanType extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['name', 'description'];

    public function predefinedPlans()
    {
        return $this->hasMany(PredefinedPlan::class);
    }

    public function chosenPlans()
    {
        return $this->hasMany(ChosenPlan::class);
    }
}
