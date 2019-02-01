<?php

namespace App\Services;

use App\Http\Resources\Warehouse as WarehouseResource;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseService
{
    public function __construct()
    {
        # code...
    }

    public function list($companyId, $perPage = 5)
    {
        $items = Warehouse::where('company_id', $companyId);
        $items = $perPage == 'all' ? $items->get() : $items->paginate((int)$perPage);
        return WarehouseResource::collection($items);
    }

    public function find($companyId, $id)
    {
        $item = Warehouse::where('company_id', $companyId)->findOrFail($id);
        return new WarehouseResource($item);
    }

    public function create($data = [])
    {
        $item = Warehouse::firstOrCreate($data);
        $item->save();
        return $item;
    }

    public function update($data = [], $id)
    {
        $item = Warehouse::where('company_id', $data['company_id'])->findOrFail($id);
        $item->update($data);
    }

    public function delete($companyId, $id)
    {
        $item = Warehouse::where('company_id', $companyId)->findOrFail($id);
        $item->delete();
    }
}
