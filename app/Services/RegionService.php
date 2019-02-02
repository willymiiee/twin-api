<?php

namespace App\Services;

use App\Models\Province;
use App\Models\District;
use App\Models\Subdistrict;
use App\Models\Village;
use Illuminate\Http\Request;

class RegionService
{
    public function list($type, $parentId = null)
    {
        switch ($type) {
            case 'province':
                $items = Province::get();
                break;

            case 'district':
                $items = District::where('province_id', $parentId)->get();
                break;

            case 'subdistrict':
                $items = Subdistrict::where('district_id', $parentId)->get();
                break;

            case 'village':
                $items = Village::where('subdistrict_id', $parentId)->get();
                break;

            default:
                $items = Province::get();
                break;
        }

        return $items;
    }
}