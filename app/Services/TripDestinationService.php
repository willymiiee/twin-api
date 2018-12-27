<?php

namespace App\Services;

use App\Http\Resources\TripDestination as TripDestinationResource;
use App\Models\TripDestination;
use Illuminate\Http\Request;

class TripDestinationService
{
    public function __construct()
    {
        # code...
    }

    public function list($tripId, $perPage = 20)
    {
        $items = TripDestination::where('trip_id', $tripId)->paginate((int)$perPage);
        return TripDestinationResource::collection($items);
    }

    public function find($tripId, $id)
    {
        $item = TripDestination::where('trip_id', $tripId)->findOrFail($id);
        return new TripDestinationResource($item);
    }

    public function update($tripId, $id, $data = [])
    {
        $item = TripDestination::where('trip_id', $tripId)->findOrFail($id)->update($data);

        if (array_key_exists('latitude', $data) && array_key_exists('longitude', $data)) {
            $item->store->update($data);
        }
    }
}
