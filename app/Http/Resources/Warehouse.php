<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Warehouse extends Resource
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
            'code' => $this->code,
            'name' => $this->name,
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
            'note' => $this->note,
            'created_at' => $this->created_at,
            'created_by' => $this->creator,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updater,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleter,
        ];
    }
}
