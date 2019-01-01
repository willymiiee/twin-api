<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobTitle extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'location_id',
        'department_id',
        'name',
        'about',
        'is_dept_head',
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

    public function roles()
    {
        return $this->hasMany('App\Models\Role');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_job_title');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }
}
