<?php

namespace App\Services;

use App\Http\Resources\ItemStock as ItemStockResource;
use App\Models\ItemStock;
use Illuminate\Http\Request;

class ItemStockService
{
    public function __construct()
    {
        # code...
    }

    public function list($warehouseId, $perPage = 5)
    {
        $items = ItemStock::where('warehouse_id', $warehouseId);
        $items = $perPage == 'all' ? $items->get() : $items->paginate((int)$perPage);
        return ItemStockResource::collection($items);
    }

    public function find($warehouseId, $code)
    {
        $item = ItemStock::where('warehouse_id', $warehouseId)
            ->where('item_code', $code)
            ->first();
        return new ItemStockResource($item);
    }

    public function update($data = [])
    {
        $item = ItemStock::firstOrNew([
            'item_code' => $data['item_code'],
            'warehouse_id' => $data['warehouse_id'],
        ]);

        $item->qty = $data['qty'];
        $item->qty_pcs = $data['qty_pcs'];

        if ($item->created_by) {
            $item->updated_by = $data['updated_by'];
        } else {
            $item->created_by = $data['created_by'];
        }

        $item->save();
    }

    public function delete($warehouseId, $code)
    {
        $item = Item::where('warehouse_id', $warehouseId)
            ->where('item_code', $code)
            ->delete();
    }
}
