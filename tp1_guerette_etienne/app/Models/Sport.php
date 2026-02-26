<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    protected $fillable = [
        'name',
    ];

    public function equipments()
    {
        return $this->belongsToMany('App\Models\Equipment', 'equipment_sport');
    }
}
