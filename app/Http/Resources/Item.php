<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Item extends Resource
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
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'weight' => $this->weight,
            'weight_unit' => $this->weight_unit,
            'unit' => $this->unit,
            'contents' => $this->contents,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
