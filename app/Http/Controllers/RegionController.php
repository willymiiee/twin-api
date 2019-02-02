<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\RegionService;

/**
 * @resource Region
 *
 * API for region
 */
class RegionController extends Controller
{
    protected $regionService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
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
        $result = [];

        if ($request->has('type') && in_array($request->type, ['province', 'district', 'subdistrict', 'village'])) {
            $result = $this->regionService->list($request->type, $request->parent_id);
        }

        return $result;
    }
}