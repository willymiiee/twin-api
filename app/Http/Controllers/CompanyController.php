<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CompanyService;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Company
 *
 * API for current user's company
 */
class CompanyController extends Controller
{
    protected $jwt;
    protected $user;
    protected $roles = [];
    protected $companyService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        JWTAuth $jwt,
        CompanyService $companyService
    ) {
        $this->jwt = $jwt;
        $this->user = $this->jwt->user();
        $this->companyService = $companyService;
        $this->roles = $this->user->jobTitles[0]->roles->where('module_id', 1)->first();
    }

    /**
     * Index
     *
     * Display the current company.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->roles->detail) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $item = $this->companyService->find($this->user->company->id);
        return $item;
    }

    /**
     * Update
     *
     * Update the current company detail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$this->roles->update) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $this->validate($request, [
            'name' => 'required'
        ]);

        $this->companyService->update($request->all(), $this->user->company->id);
        return response()->json([]);
    }
}
