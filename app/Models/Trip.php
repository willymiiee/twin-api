<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'type',
        'user_id',
        'created_by',
        'updated_by',
        'started_at',
        'ended_at',
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

    public function destinations()
    {
        return $this->hasMany('App\Models\TripDestination');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }

    public function driver()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo('App\Models\User', 'deleted_by');
    }
}
