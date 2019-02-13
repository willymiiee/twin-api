<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

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

    public function depots()
    {
        return $this->hasMany('App\Models\Depot');
    }

    public function stocks()
    {
        return $this->hasMany('App\Models\ItemStock');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    public function subdistrict()
    {
        return $this->belongsTo('App\Models\Subdistrict');
    }

    public function village()
    {
        return $this->belongsTo('App\Models\Village');
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
