<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function subdistricts()
    {
        return $this->hasMany('App\Models\Subdistrict');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }
}
