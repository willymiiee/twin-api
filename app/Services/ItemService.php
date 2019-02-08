<?php

namespace App\Services;

use App\Http\Resources\Item as ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemService
{
    public function __construct()
    {
        # code...
    }

    public function list($companyId, $perPage = 5)
    {
        $items = Item::where('company_id', $companyId);
        $items = $perPage == 'all' ? $items->get() : $items->paginate((int)$perPage);
        return ItemResource::collection($items);
    }

    public function find($companyId, $code)
    {
        $item = Item::where('company_id', $companyId)
            ->where('code', $code)
            ->first();
        return new ItemResource($item);
    }

    public function create($data = [])
    {
        $item = Item::firstOrCreate($data);
        return $item;
    }

    public function update($data = [], $code)
    {
        $item = Item::where('company_id', $data['company_id'])
            ->where('code', $code)
            ->update($data);
    }

    public function delete($companyId, $code)
    {
        $item = Item::where('company_id', $companyId)
            ->where('code', $code)
            ->delete();
    }
}
