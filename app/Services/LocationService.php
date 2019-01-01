<?php

namespace App\Services;

use App\Http\Resources\Location as LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationService
{
    public function __construct()
    {
        # code...
    }

    public function list($companyId, $perPage = 5)
    {
        $items = Location::where('company_id', $companyId);
        $items = $perPage == 'all' ? $items->get() : $items->paginate((int)$perPage);
        return LocationResource::collection($items);
    }

    public function find($companyId, $id)
    {
        $item = Location::where('company_id', $companyId)->findOrFail($id);
        return new LocationResource($item);
    }

    public function create($data = [])
    {
        $data['timezone'] = !array_key_exists('timezone', $data) ? Location::DEFAULT_TIMEZONE : $data['timezone'];
        $data['currency'] = !array_key_exists('currency', $data) ? Location::DEFAULT_CURRENCY : $data['currency'];
        $data['country'] = !array_key_exists('country', $data) ? Location::DEFAULT_COUNTRY : $data['country'];

        $item = new Location($data);
        $item->save();
        return $item;
    }

    public function update($companyId, $data = [], $id)
    {
        $item = Location::where('company_id', $companyId)->findOrFail($id);
        $item->update($data);
    }

    public function delete($companyId, $id)
    {
        $item = Location::where('company_id', $companyId)->findOrFail($id);
        $item->delete();
    }
}
