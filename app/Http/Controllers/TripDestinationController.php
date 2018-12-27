<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TripDestinationService;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Trip Destination
 *
 * API for trip destination management
 */
class TripDestinationController extends Controller
{
    protected $jwt;
    protected $user;
    protected $roles = [];
    protected $tripDestinationService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        JWTAuth $jwt,
        TripDestinationService $tripDestinationService
    ) {
        $this->jwt = $jwt;
        $this->user = $this->jwt->user();
        $this->tripDestinationService = $tripDestinationService;
        $this->roles = $this->user->jobTitles[0]->roles->where('module_id', 8)->first();
    }

    /**
     * Index
     *
     * Display a listing of the resource.
     *
     * @param  int  $tripId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index($tripId, Request $request)
    {
        if (!$this->roles->list) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $items = $this->tripDestinationService->list($tripId, $request->has('per_page') ? $request->per_page : 20);
        return $items;
    }

    /**
     * Show
     *
     * Display the specified resource.
     *
     * @param  int  $tripId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tripId, $id)
    {
        if (!$this->roles->detail) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $item = $this->tripDestinationService->find($tripId, $id);
        return $item;
    }

    /**
     * Update
     *
     * Update the specified resource in storage.
     *
     * @param  int  $tripId
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($tripId, $id, Request $request)
    {
        if (!$this->roles->update) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $this->validate($request, [
            'status_destination' => 'required|in:incomplete,complete',
            'latitude' => 'filled',
            'longitude' => 'filled',
        ]);

        $input = $request->all();
        $input['status'] = $input['status_destination'];
        $this->tripDestinationService->update($tripId, $id, $input);
        return response()->json([]);
    }
}
