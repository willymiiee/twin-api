<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Role extends Resource
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
            'module_id' => $this->module_id,
            'sub_module_id' => $this->sub_module_id,
            'list' => $this->list,
            'detail' => $this->detail,
            'create' => $this->create,
            'update' => $this->update,
            'delete' => $this->delete,
        ];
    }
}
