<?php

namespace App\Services;

use App\Http\Resources\TripDestination as TripDestinationResource;
use App\Models\Trip;
use App\Models\TripDestination;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        $trip = Trip::findOrFail($tripId);
        $completed = $trip->destinations()->where('status', 'complete')->get();
        if ($completed->count() == 0)
            $trip->update(['started_at' => Carbon::now()]);

        $item = TripDestination::where('trip_id', $tripId)->findOrFail($id);
        $item->update($data);

        $completed = $trip->destinations()->where('status', 'complete')->get();
        if ($completed->count() == $trip->destinations()->count())
            $trip->update(['ended_at' => Carbon::now()]);
    }
}
