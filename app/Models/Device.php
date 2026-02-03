<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['plant_id', 'type', 'mode', 'status'];

    public function plant()
    {
        return $this->belongsTo(GreenhousePlant::class, 'plant_id');
    }
}
