<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripDestination extends Model
{
    const STATUS_INCOMPLETE  = 'incomplete';
    const STATUS_COMPLETE    = 'complete';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function trip()
    {
        return $this->belongsTo('App\Models\Trip');
    }

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function items()
    {
        return $this->hasMany('App\Models\TripDestinationItem');
    }
}
