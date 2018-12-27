<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class JobTitle extends Resource
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
            'about' => $this->about,
            'is_dept_head' => $this->is_dept_head,
            'location' => $this->location,
            'department' => $this->department,
            'roles' => $this->roles,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
