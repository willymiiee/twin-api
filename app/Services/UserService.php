<?php

namespace App\Services;

use App\Http\Resources\User as UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserService
{
    public function __construct()
    {
        # code...
    }

    public function list($jobTitleIds, $perPage = 5)
    {
        $items = User::whereHas('jobTitles', function($q) use ($jobTitleIds) {
            $q->whereIn('job_titles.id', $jobTitleIds);
        });
        $items = $perPage == 'all' ? $items->get() : $items->paginate((int)$perPage);
        return UserResource::collection($items);
    }

    public function find($id)
    {
        $item = User::findOrFail($id);
        return new UserResource($item);
    }

    public function create($data = [])
    {
        $item = new User($data);
        $item->save();

        if (array_key_exists('jobtitle', $data))
            $item->jobTitles()->sync($data['jobtitle']);

        return $item;
    }

    public function update($id, $data = [])
    {
        $item = User::find($id);
        $item->update($data);

        if (array_key_exists('jobtitle', $data)) {
            $item->jobTitles()->sync($data['jobtitle']);
        }

        return $item;
    }

    public function findUserCompany($id)
    {
        $item = User::find($id);
        return $item->company;
    }
}
