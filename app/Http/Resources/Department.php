<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Department extends Resource
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
            'location' => $this->location,
            'job_titles' => JobTitle::collection($this->jobTitles),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
