<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PrincipalService;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Principal
 *
 * API for principal management
 */
class PrincipalController extends Controller
{
    protected $jwt;
    protected $user;
    protected $roles = [];
    protected $principalService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        JWTAuth $jwt,
        PrincipalService $principalService
    ) {
        $this->jwt = $jwt;
        $this->user = $this->jwt->user();
        $this->principalService = $principalService;
        $this->roles = $this->user->jobTitles[0]->roles->where('module_id', 14)->first();
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

        $items = $this->principalService->list($this->user->company->id, $request->has('per_page') ? $request->per_page : 5);
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
            'name' => 'required',
        ]);

        $input = $request->all();
        $input['company_id'] = $this->user->company->id;
        $input['created_by'] = $this->user->id;

        $this->principalService->create($input);
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

        $item = $this->principalService->find($this->user->company->id, $id);
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
            'name' => 'required',
        ]);

        $input = $request->all();
        $input['company_id'] = $this->user->company->id;
        $input['updated_by'] = $this->user->id;

        $this->principalService->update($input, $id);
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

        $this->principalService->update($data, $id);
        $this->principalService->delete($this->user->company->id, $id);
        return response()->json([]);
    }
}
