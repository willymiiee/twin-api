<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\LocationService;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Location
 *
 * API for current company's location
 */
class LocationController extends Controller
{
    protected $jwt;
    protected $user;
    protected $roles = [];
    protected $locationService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        JWTAuth $jwt,
        LocationService $locationService
    ) {
        $this->jwt = $jwt;
        $this->user = $this->jwt->user();
        $this->locationService = $locationService;
        $this->roles = $this->user->jobTitles[0]->roles->where('module_id', 2)->first();
    }

    /**
     * Index
     *
     * Display the locations on current company.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$this->roles->list) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $items = $this->locationService->list($this->user->company->id, $request->has('per_page') ? $request->per_page : 5);
        return $items;
    }

    /**
     * Store
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$this->roles->create) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $this->validate($request, [
            'name' => 'required'
        ]);

        $input = $request->all();
        $input['company_id'] = $this->user->company->id;

        $this->locationService->create($input);
        return response()->json([], 201);
    }

    /**
     * Show
     *
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$this->roles->detail) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $item = $this->locationService->find($this->user->company->id, $id);
        return $item;
    }

    /**
     * Update
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$this->roles->update) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $this->validate($request, [
            'name' => 'required'
        ]);

        $this->locationService->update($this->user->company->id, $request->all(), $id);
        return response()->json([]);
    }

    /**
     * Destroy
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->roles->delete) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $this->locationService->delete($this->user->company->id, $id);
        return response()->json([]);
    }
}
