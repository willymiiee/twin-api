<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Depot extends Model
{
    use SoftDeletes;

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
        'phone',
        'province_id',
        'district_id',
        'subdistrict_id',
        'village_id',
        'zipcode',
        'created_by',
        'updated_by',
        'deleted_by',
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

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse');
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
