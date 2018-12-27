<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'started_at',
        'ended_at',
        'created_at',
        'updated_at',
    ];

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function driver()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function destinations()
    {
        return $this->hasMany('App\Models\TripDestination');
    }
}
