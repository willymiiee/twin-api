<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Company as CompanyResource;
use App\Http\Resources\JobTitle as JobTitleResource;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use App\Services\CompanyService;
use App\Services\UserService;
use App\Services\UserActivationService;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Authentication
 *
 * API for authentication
 */
class AuthController extends Controller
{
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * Login
     *
     * API for user to log in
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required_without:phone|email',
            'phone'     => 'required_without:email',
            'password' => 'required'
        ]);

        if ($request->has('email'))
            $auth = 'email';
        elseif ($request->has('phone'))
            $auth = 'phone';

        try {
            if (!$token = $this->jwt->attempt([
                $auth => $request->$auth,
                'password' => $request->password,
                'status' => User::STATUS_ACTIVE
            ])) {
                return response()->json(['error' => 'User not found!'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token Expired!'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token Invalid!'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json([
            'token' => $token,
            'user' => new UserResource($this->jwt->user()),
            'company' => new CompanyResource($this->jwt->user()->company),
            'jobtitle' => JobTitleResource::collection($this->jwt->user()->jobTitles)
        ]);
    }

    /**
     * Register
     *
     * API for anyone to register a new company
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|confirmed|min:8|max:16',
            'company_name' => 'required',
        ]);

        $companyService = new CompanyService;
        $userService = new UserService;
        $userActivationService = new UserActivationService;

        $input = $request->except(['password_confirmation', 'company_name']);
        $input['password'] = app('hash')->make($input['password']);

        try {
            $user = $userService->create($input);
            $userActivation = $userActivationService->create($user->id);
            $company = $companyService->signup($user, $request->company_name);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $result['name'] =  $user->name;
        $result['company'] = $company->name;
        $result['activation_token'] = $userActivation->token;

        return response()->json($result, 200);
    }

    /**
     * Activate User
     *
     * API for activate a new user
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function activate($token = '')
    {
        $userService = new UserService;
        $userActivationService = new UserActivationService;
        $activation = $userActivationService->find($token);

        if ($activation) {
            $userService->update($activation->user_id, ['status' => User::STATUS_ACTIVE]);
            return response()->json(['message' => 'User activated!']);
        }

        return response()->json(['error' => 'User not found!'], 400);
    }
}
