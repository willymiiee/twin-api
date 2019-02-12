<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ItemPriceService;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Item
 *
 * API for item price management
 */
class ItemPriceController extends Controller
{
    protected $jwt;
    protected $user;
    protected $roles = [];
    protected $priceService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        JWTAuth $jwt,
        ItemPriceService $priceService
    ) {
        $this->jwt = $jwt;
        $this->user = $this->jwt->user();
        $this->priceService = $priceService;
        $this->roles = $this->user->jobTitles[0]->roles->where('module_id', 10)->first();
    }

    /**
     * Index
     *
     * Display a listing of the resource.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function index($code)
    {
        if (!$this->roles->list) {
            return response()->json(['error' => 'Unauthorized!'], 401);
        }

        $items = $this->priceService->list($code);
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
            'item_code' => 'required|exists:items,code',
            'prices' => 'required',
        ]);

        foreach ($request->prices as $t => $p) {
            if ($p) {
                $data = [
                    'type' => strtoupper($t),
                    'price' => $p,
                    'created_by' => $this->user->id,
                    'updated_by' => $this->user->id,
                ];
                $this->priceService->update($request->item_code, $data);
            }
        }

        return response()->json([], 200);
    }
}
