<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\WarehouseService;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Warehouse
 *
 * API for warehouse management
 */
class WarehouseController extends Controller
{
    protected $jwt;
    protected $user;
    protected $roles = [];
    protected $warehouseService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        JWTAuth $jwt,
        WarehouseService $warehouseService
    ) {
        $this->jwt = $jwt;
        $this->user = $this->jwt->user();
        $this->warehouseService = $warehouseService;
        $this->roles = $this->user->jobTitles[0]->roles->where('module_id', 11)->first();
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

        $items = $this->warehouseService->list($this->user->company->id, $request->has('per_page') ? $request->per_page : 5);
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
            'code' => 'required',
            'name' => 'required',
        ]);

        $input = $request->all();
        $input['company_id'] = $this->user->company->id;
        $input['created_by'] = $this->user->id;

        $this->warehouseService->create($input);
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

        $item = $this->warehouseService->find($this->user->company->id, $id);
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
            'code' => 'required',
            'name' => 'required',
        ]);

        $input = $request->all();
        $input['company_id'] = $this->user->company->id;
        $input['updated_by'] = $this->user->id;

        $this->warehouseService->update($input, $id);
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

        $data = [
            'company_id' => $this->user->company->id,
            'deleted_by' => $this->user->id,
        ];

        $this->warehouseService->update($data, $id);
        $this->warehouseService->delete($this->user->company->id, $id);
        return response()->json([]);
    }
}
