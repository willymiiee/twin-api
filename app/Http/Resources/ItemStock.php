<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ItemStock extends Resource
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
            'item_code' => $this->item_code,
            'warehouse_id' => $this->warehouse_id,
            'name' => $this->item->name,
            'qty' => $this->qty,
            'qty_pcs' => $this->qty_pcs,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
