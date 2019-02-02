<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripDestination extends Model
{
    const STATUS_INCOMPLETE  = 'incomplete';
    const STATUS_COMPLETE    = 'complete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'trip_id',
        'store_id',
        'latitude',
        'longitude',
        'status',
        'payment_type',
        'term_of_payment',
        'limit',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

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
