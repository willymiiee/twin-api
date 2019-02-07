<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Store extends Resource
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
            'acc_number' => $this->acc_number,
            'mars_code' => $this->mars_code,
            'key_person' => $this->acc_number,
            'type' => $this->type,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'phone' => $this->phone,
            'zipcode' => $this->zipcode,
            'province' => $this->province,
            'district' => $this->district,
            'subdistrict' => $this->subdistrict,
            'village' => $this->village,
            'created_at' => $this->created_at,
            'created_by' => $this->creator,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updater,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleter,
        ];
    }
}
