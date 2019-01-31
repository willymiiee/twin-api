<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function districts()
    {
        return $this->hasMany('App\Models\District');
    }
}
