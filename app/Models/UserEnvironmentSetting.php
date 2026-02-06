<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEnvironmentSetting extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'user_id',
        'plan_name',
        'temperature',
        'humidity',
        'soil_moisture',
        'is_customized',
    ];
}
