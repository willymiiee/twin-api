<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ItemStockService;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Item
 *
 * API for item stock management
 */
class ItemStockController extends Controller
{
    protected $jwt;
    protected $user;
    protected $roles = [];
    protected $stockService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        JWTAuth $jwt,
        ItemStockService $stockService
    ) {
        $this->jwt = $jwt;
        $this->user = $this->jwt->user();
        $this->stockService = $stockService;
        $this->roles = $this->user->jobTitles[0]->roles->where('module_id', 15)->first();
    }

    /**
     * Index
     *
     * Display a listing of the resource.
     *
     * @param  int  $warehouseId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index($warehouseId, Request $request)
    {
        if (!$this->roles->list) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $items = $this->stockService->list($warehouseId, $request->has('per_page') ? $request->per_page : 5);
        return $items;
    }

    /**
     * Store
     *
     * Store a newly created resource in storage.
     *
     * @param  int  $warehouseId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($warehouseId, Request $request)
    {
        if (!$this->roles->create) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $this->validate($request, [
            'item_code' => 'required|exists:items,code',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        $input = $request->all();
        $input['created_by'] = $this->user->id;

        $this->stockService->update($input);
        return response()->json([], 200);
    }

    /**
     * Show
     *
     * Display the specified resource.
     *
     * @param  int  $warehouseId
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function show($warehouseId, $code)
    {
        if (!$this->roles->detail) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $item = $this->stockService->find($warehouseId, $code);
        return $item;
    }

    /**
     * Update
     *
     * Update the specified resource in storage.
     *
     * @param  int  $warehouseId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($warehouseId, Request $request)
    {
        if (!$this->roles->update) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $this->validate($request, [
            'item_code' => 'required|exists:items,code',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        $input = $request->all();
        $input['updated_by'] = $this->user->id;

        $this->stockService->update($input);
        return response()->json([]);
    }

    /**
     * Destroy
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $warehouseId
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function destroy($warehouseId, $code)
    {
        if (!$this->roles->delete) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $this->stockService->delete($warehouseId, $code);
        return response()->json([]);
    }
}
