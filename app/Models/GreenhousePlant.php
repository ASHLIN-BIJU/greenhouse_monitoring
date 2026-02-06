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
}
