<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\DepartmentService;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Department
 *
 * API for current company's department
 */
class DepartmentController extends Controller
{
    protected $jwt;
    protected $user;
    protected $roles = [];
    protected $departmentService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        JWTAuth $jwt,
        DepartmentService $departmentService
    ) {
        $this->jwt = $jwt;
        $this->user = $this->jwt->user();
        $this->departmentService = $departmentService;
        $this->roles = $this->user->jobTitles[0]->roles->where('module_id', 3)->first();
    }

    /**
     * Index
     *
     * Display the departments on current company.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$this->roles->list) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $items = $this->departmentService->list($this->user->company->id, $request->get('location_id'), $request->has('per_page') ? $request->per_page : 5);
        return $items;
    }

    /**
     * Store
     *
     * Store a new department for the current company.
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
            'location_id' => 'required|exists:locations,id|integer',
            'name' => 'required',
        ]);

        $input = $request->all();
        $input['company_id'] = $this->user->company->id;

        $this->departmentService->create($input);
        return response()->json([], 201);
    }

    /**
     * Show
     *
     * Display the specific department.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$this->roles->detail) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $item = $this->departmentService->find($this->user->company->id, $id);
        return $item;
    }

    /**
     * Update
     *
     * Update the specified department.
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
            'location_id' => 'required|exists:locations,id|integer',
            'name' => 'required',
        ]);

        $this->departmentService->update($this->user->company->id, $request->all(), $id);
        return response()->json([]);
    }

    /**
     * Destroy
     *
     * Remove the specified department.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->roles->delete) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $this->departmentService->delete($this->user->company->id, $id);
        return response()->json([]);
    }
}
