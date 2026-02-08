<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceSetting extends Model
{
    protected $fillable = [
        'user_id',
        'ac_mode',
        'exhaust_mode',
        'pump_mode',
        'target_temp',
        'target_humidity',
        'target_soil'
    ];
}
