<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TripService;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Trip
 *
 * API for trip management
 */
class TripController extends Controller
{
    protected $jwt;
    protected $user;
    protected $roles = [];
    protected $tripService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        JWTAuth $jwt,
        TripService $tripService
    ) {
        $this->jwt = $jwt;
        $this->user = $this->jwt->user();
        $this->tripService = $tripService;
        $this->roles = $this->user->jobTitles[0]->roles->where('module_id', 8)->first();
    }

    /**
     * Index
     *
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$this->roles->list) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $items = $this->tripService->list($this->user->company->id, $request->has('per_page') ? $request->per_page : 5, $request->get('user_id'));
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
            'type' => 'required|in:sales,logistic',
            'user_id' => 'required|exists:users,id|integer',
            'destination' => 'required|array',
        ]);

        $input = $request->all();
        $input['company_id'] = $this->user->company->id;
        $input['created_by'] = $this->user->id;

        try {
            $this->tripService->create($input);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getStatusCode());
        }

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

        $companyId = $this->user->company->id;
        $item = $this->tripService->find($companyId, $id);
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
            'type' => 'required|in:sales,logistic',
            'user_id' => 'required|exists:users,id|integer',
            'destination' => 'required|array',
        ]);

        $input = $request->all();
        $input['company_id'] = $this->user->company->id;
        $input['updated_by'] = $this->user->id;

        $this->tripService->update($input, $id);
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

        $companyId = $this->user->company->id;
        $this->tripService->delete($companyId, $id);
        return response()->json([]);
    }
}
