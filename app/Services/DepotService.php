<?php

namespace App\Services;

use App\Http\Resources\Depot as DepotResource;
use App\Models\Depot;
use Illuminate\Http\Request;

class DepotService
{
    public function __construct()
    {
        # code...
    }

    public function list($companyId, $perPage = 5)
    {
        $items = Depot::where('company_id', $companyId);
        $items = $perPage == 'all' ? $items->get() : $items->paginate((int)$perPage);
        return DepotResource::collection($items);
    }

    public function find($companyId, $id)
    {
        $item = Depot::where('company_id', $companyId)->findOrFail($id);
        return new DepotResource($item);
    }

    public function create($data = [])
    {
        $item = Depot::firstOrCreate($data);
        $item->save();
        return $item;
    }

    public function update($data = [], $id)
    {
        $item = Depot::where('company_id', $data['company_id'])->findOrFail($id);
        $item->update($data);
    }

    public function delete($companyId, $id)
    {
        $item = Depot::where('company_id', $companyId)->findOrFail($id);
        $item->delete();
    }
}
