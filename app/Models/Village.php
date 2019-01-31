<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function subdistrict()
    {
        return $this->belongsTo('App\Models\Subdistrict');
    }
}
