<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource User
 *
 * API for current company's users
 */
class UserController extends Controller
{
    protected $jwt;
    protected $user;
    protected $roles = [];
    protected $userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        JWTAuth $jwt,
        UserService $userService
    ) {
        $this->jwt = $jwt;
        $this->user = $this->jwt->user();
        $this->userService = $userService;
        $this->roles = $this->user->jobTitles[0]->roles->where('module_id', 6)->first();
    }

    /**
     * Index
     *
     * Display a listing of the resource.
     *
     * @param  int  $departmentId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$this->roles->list) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $jobTitleIds = [];
        $jobTitles = $this->user->company->jobTitles->toArray();

        foreach ($jobTitles as $j) {
            $jobTitleIds[] = $j['id'];
        }

        $items = $this->userService->list($jobTitleIds, $request->has('per_page') ? $request->per_page : 5);
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
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|confirmed|min:8|max:16',
        ]);

        $input = $request->all();
        $input['password'] = app('hash')->make($input['password']);

        $this->userService->create($input);
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

        $item = $this->userService->find($id);
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
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|confirmed|min:8|max:16',
        ]);

        $this->userService->update($id, $request->all());
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
        //
    }
}
