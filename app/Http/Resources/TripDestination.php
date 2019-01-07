<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TripDestination extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $store = $this->store;
        return [
            'id' => $this->id,
            'name' => $store->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'status' => $this->status,
            'checked' => $this->status == 'complete',
        ];
    }
}
