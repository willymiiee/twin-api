<?php

namespace App\Services;

use App\Http\Resources\Principal as PrincipalResource;
use App\Models\Principal;
use Illuminate\Http\Request;

class PrincipalService
{
    public function __construct()
    {
        # code...
    }

    public function list($companyId, $perPage = 5)
    {
        $items = Principal::where('company_id', $companyId);
        $items = $perPage == 'all' ? $items->get() : $items->paginate((int)$perPage);
        return PrincipalResource::collection($items);
    }

    public function find($companyId, $id)
    {
        $item = Principal::where('company_id', $companyId)->findOrFail($id);
        return new PrincipalResource($item);
    }

    public function create($data = [])
    {
        $item = Principal::firstOrCreate($data);
        $item->save();
        return $item;
    }

    public function update($data = [], $id)
    {
        $item = Principal::where('company_id', $data['company_id'])->findOrFail($id);
        $item->update($data);
    }

    public function delete($companyId, $id)
    {
        $item = Principal::where('company_id', $companyId)->findOrFail($id);
        $item->delete();
    }
}
