<?php

namespace App\Services;

use App\Http\Resources\Department as DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentService
{
    public function __construct()
    {
        # code...
    }

    public function list($companyId, $locationId = null, $perPage = 5)
    {
        $items = Department::where('company_id', $companyId);
        $items = $locationId ? $items->where('location_id', $locationId) : $items;
        $items = $perPage == 'all' ? $items->get() : $items->paginate((int)$perPage);
        return DepartmentResource::collection($items);
    }

    public function find($companyId, $id)
    {
        $item = Department::where('company_id', $companyId)->findOrFail($id);
        return new DepartmentResource($item);
    }

    public function create($data = [])
    {
        $item = new Department($data);
        $item->save();
        return $item;
    }

    public function update($companyId, $data = [], $id)
    {
        $item = Department::where('company_id', $companyId)->findOrFail($id)->update($data);
    }

    public function delete($companyId, $id)
    {
        $item = Department::where('company_id', $companyId)->findOrFail($id);
        $item->delete();
    }
}
