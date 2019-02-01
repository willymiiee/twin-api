<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements JWTSubject, AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, SoftDeletes;
    const STATUS_ACTIVE             = 'active';
    const STATUS_NON_ACTIVE         = 'non_active';
    const STATUS_NEED_ACTIVATION    = 'need_activation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'identity_number',
        'driver_license',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function jobTitles()
    {
        return $this->belongsToMany('App\Models\JobTitle', 'user_job_title');
    }

    public function company()
    {
        $jobTitles = $this->jobTitles();
        return $jobTitles->get()[0]->company();
    }

    public function activationCode()
    {
        return $this->hasOne('App\Models\UserActivation');
    }

    public function team()
    {
        return $this->belongsToMany('App\Models\Team', 'user_team')->withPivot('code', 'area');
    }
}
