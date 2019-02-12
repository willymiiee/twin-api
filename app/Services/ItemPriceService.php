<?php

namespace App\Services;

use App\Http\Resources\ItemPrice as ItemPriceResource;
use App\Models\ItemPrice;
use Illuminate\Http\Request;

class ItemPriceService
{
    public function __construct()
    {
        # code...
    }

    public function list($code)
    {
        $items = ItemPrice::where('item_code', $code)->get();
        return ItemPriceResource::collection($items);
    }

    public function update($code, $data = [])
    {
        $item = ItemPrice::firstOrNew([
            'item_code' => $code,
            'type' => $data['type']
        ]);

        $item->price = $data['price'];

        if ($item->created_by) {
            $item->updated_by = $data['updated_by'];
        } else {
            $item->created_by = $data['created_by'];
        }

        $item->save();
    }
}
