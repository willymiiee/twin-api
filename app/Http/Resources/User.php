<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'status' => $this->status,
            // 'company' => new Company($jobTitles[0]->company),
            // 'location' => new Location($jobTitles[0]->location),
            // 'department' => new Department($jobTitles[0]->department),
            'job-title' => JobTitle::collection($this->jobTitles),
            // 'role' => Role::collection($jobTitles[0]->roles),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
