<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'name',
        'description',
        'daily_price',
    ];

    public function categorie()
    {
        return $this->belongsTo('App\Models\Categorie');
    }

    public function rentals()
    {
        return $this->hasMany('App\Models\Rental');
    }

    public function sports()
    {
        return $this->belongsToMany('App\Models\Sport', 'equipment_sport');
    }
}
