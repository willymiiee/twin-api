<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Depot extends Resource
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
            'warehouse' => new Warehouse($this->warehouse),
            'name' => $this->name,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'phone' => $this->phone,
            'zipcode' => $this->zipcode,
            'province' => $this->province,
            'district' => $this->district,
            'subdistrict' => $this->subdistrict,
            'village' => $this->village,
            'team' => $this->teams,
            'created_at' => $this->created_at,
            'created_by' => $this->creator,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updater,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleter,
        ];
    }
}
