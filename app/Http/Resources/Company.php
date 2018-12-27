<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Company extends Resource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'logo' => $this->logo,
            'about' => $this->about,
            // 'locations' => Location::collection($this->locations),
            // 'departments' => Department::collection($this->departments),
            // 'job-titles' => JobTitle::collection($this->jobTitles),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
