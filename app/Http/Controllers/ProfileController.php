<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TripService;
use App\Services\TripDestinationService;
use App\Services\UserService;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Profile
 *
 * API for current user's profile
 */
class ProfileController extends Controller
{
    protected $jwt;
    protected $user;
    protected $roles = [];
    protected $tripService;
    protected $tripDestinationService;
    protected $userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        JWTAuth $jwt,
        TripService $tripService,
        TripDestinationService $tripDestinationService,
        UserService $userService
    ) {
        $this->jwt = $jwt;
        $this->user = $this->jwt->user();
        $this->tripService = $tripService;
        $this->tripDestinationService = $tripDestinationService;
        $this->userService = $userService;
    }

    /**
     * Current Active Trips
     *
     * Display a listing of active trips.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function activeTrips(Request $request)
    {
        $items = $this->tripService->list($this->user->company->id, $request->has('per_page') ? $request->per_page : 5, $this->user->id, 'active');
        return $items;
    }

    /**
     * Trips History
     *
     * Display a listing of completed trips.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tripHistory(Request $request)
    {
        $items = $this->tripService->list($this->user->company->id, $request->has('per_page') ? $request->per_page : 5, $this->user->id, 'completed');
        return $items;
    }

    /**
     * Show Trip
     *
     * Display the specified trip.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tripDetail($id)
    {
        $item = $this->tripService->find($this->user->company->id, $id);
        return $item;
    }

    /**
     * Update Trip Destination
     *
     * Update the specified destination on trip.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTripDestination(Request $request, $tripId, $id)
    {
        $this->validate($request, [
            'latitude' => 'required',
            'longitude' => 'required',
            'status' => 'required|in:complete,incomplete',
        ]);

        $this->tripDestinationService->update($tripId, $id, $request->all());
        return response()->json([]);
    }
}
