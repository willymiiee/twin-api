<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;
    const DEFAULT_TIMEZONE  = 'UTC+8';
    const DEFAULT_CURRENCY  = 'IDR';
    const DEFAULT_COUNTRY   = 'ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'name',
        'address',
        'latitude',
        'longitude',
        'country',
        'state',
        'city',
        'timezone',
        'currency',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function departments()
    {
        return $this->hasMany('App\Models\Department');
    }

    public function jobTitles()
    {
        return $this->hasMany('App\Models\JobTitle');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
