<?php

namespace App\Services;

use App\Http\Resources\Store as StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreService
{
    public function __construct()
    {
        # code...
    }

    public function list($companyId, $perPage = 5)
    {
        $items = Store::where('company_id', $companyId);
        $items = $perPage == 'all' ? $items->get() : $items->paginate((int)$perPage);
        return StoreResource::collection($items);
    }

    public function find($companyId, $id)
    {
        $item = Store::where('company_id', $companyId)->findOrFail($id);
        return new StoreResource($item);
    }

    public function create($data = [])
    {
        $item = Store::firstOrCreate($data);
        $item->save();
        return $item;
    }

    public function update($data = [], $id)
    {
        Store::where('company_id', $data['company_id'])->findOrFail($id)->update($data);
    }

    public function delete($companyId, $id)
    {
        $item = Store::where('company_id', $companyId)->findOrFail($id);
        $item->delete();
    }
}
