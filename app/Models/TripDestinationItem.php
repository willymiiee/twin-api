<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripDestinationItem extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function tripDestination()
    {
        return $this->belongsTo('App\Models\TripDestination');
    }

    public function item()
    {
        return $this->belongsToMany('App\Models\Item');
    }
}
