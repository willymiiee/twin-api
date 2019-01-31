<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function villages()
    {
        return $this->hasMany('App\Models\Village');
    }

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }
}
