<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\JobTitleService;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Job Title
 *
 * API for current company's job titles
 */
class JobTitleController extends Controller
{
    protected $jwt;
    protected $user;
    protected $roles = [];
    protected $jobTitleService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        JWTAuth $jwt,
        JobTitleService $jobTitleService
    ) {
        $this->jwt = $jwt;
        $this->user = $this->jwt->user();
        $this->jobTitleService = $jobTitleService;
        $this->roles = $this->user->jobTitles[0]->roles->where('module_id', 4)->first();
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

        $items = $this->jobTitleService->list($this->user->company->id, $request->get('department_id'), $request->has('per_page') ? $request->per_page : 5);
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
            'location_id' => 'required|exists:locations,id|integer',
            'department_id' => 'required|exists:departments,id|integer',
            'name' => 'required',
            'is_dept_head' => 'required|boolean',
            'roles' => 'required|array',
            'roles.*.list' => 'required|boolean',
            'roles.*.detail' => 'required|boolean',
            'roles.*.create' => 'required|boolean',
            'roles.*.update' => 'required|boolean',
            'roles.*.delete' => 'required|boolean',
        ]);

        $input = $request->all();
        $input['company_id'] = $this->user->company->id;

        $this->jobTitleService->create($input);
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

        $item = $this->jobTitleService->find($this->user->company->id, $id);
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
            'location_id' => 'required|exists:locations,id|integer',
            'department_id' => 'required|exists:departments,id|integer',
            'name' => 'required',
            'is_dept_head' => 'required|boolean',
            'roles' => 'required|array',
            'roles.*.list' => 'required|boolean',
            'roles.*.detail' => 'required|boolean',
            'roles.*.create' => 'required|boolean',
            'roles.*.update' => 'required|boolean',
            'roles.*.delete' => 'required|boolean',
        ]);

        $this->jobTitleService->update($this->user->company->id, $request->all(), $id);
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

        $this->jobTitleService->delete($this->user->company->id, $id);
        return response()->json([]);
    }
}
