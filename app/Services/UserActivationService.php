<?php

namespace App\Services;

use App\Models\UserActivation;
use Illuminate\Http\Request;

class UserActivationService
{
    public function __construct()
    {
        # code...
    }

    public function create($userId = '')
    {
        $item = new UserActivation;
        $item->user_id = $userId;
        $item->token = str_random(64);
        $item->save();
        return $item;
    }

    public function find($token = '')
    {
        $item = UserActivation::where('token', $token)->first();
        return $item;
    }
}
