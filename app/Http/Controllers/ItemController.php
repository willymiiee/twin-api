<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ItemService;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Item
 *
 * API for item management
 */
class ItemController extends Controller
{
    protected $jwt;
    protected $user;
    protected $roles = [];
    protected $itemService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        JWTAuth $jwt,
        ItemService $itemService
    ) {
        $this->jwt = $jwt;
        $this->user = $this->jwt->user();
        $this->itemService = $itemService;
        $this->roles = $this->user->jobTitles[0]->roles->where('module_id', 10)->first();
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

        $companyId = $this->user->company->id;
        $items = $this->itemService->list($companyId, $request->has('per_page') ? $request->per_page : 5);
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
            'code' => 'required|unique:items',
            'name' => 'required',
            'unit' => 'required',
            'contents' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'weight_unit' => 'required',
        ]);

        $input = $request->all();
        $input['company_id'] = $this->user->company->id;
        $input['created_by'] = $this->user->id;

        $this->itemService->create($input);
        return response()->json([], 201);
    }

    /**
     * Show
     *
     * Display the specified resource.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        if (!$this->roles->detail) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $companyId = $this->user->company->id;
        $item = $this->itemService->find($companyId, $code);
        return $item;
    }

    /**
     * Update
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $code)
    {
        if (!$this->roles->update) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $this->validate($request, [
            'code' => 'required|unique:items,code,'.$code.',code',
            'name' => 'required',
            'unit' => 'required',
            'contents' => 'required|min:0',
            'weight' => 'required|min:0',
            'weight_unit' => 'required',
        ]);

        $input = $request->all();
        $input['company_id'] = $this->user->company->id;
        $input['updated_by'] = $this->user->id;

        $this->itemService->update($input, $code);
        return response()->json([]);
    }

    /**
     * Destroy
     *
     * Remove the specified resource from storage.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        if (!$this->roles->delete) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $data = [
            'company_id' => $this->user->company->id,
            'deleted_by' => $this->user->id,
        ];

        $this->itemService->update($data, $code);
        $this->itemService->delete($this->user->company->id, $code);
        return response()->json([]);
    }
}
