<?php

namespace App\Services;

use App\Http\Resources\Trip as TripResource;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripService
{
    public function __construct()
    {
        # code...
    }

    public function list($companyId, $perPage = 5, $userId = null)
    {
        $items = Trip::where('company_id', $companyId);
        $items = $userId ? $items->where('user_id', $userId) : $items;
        $items = $items->paginate((int)$perPage);
        return TripResource::collection($items);
    }

    public function find($companyId, $id)
    {
        $item = Trip::where('company_id', $companyId)->findOrFail($id);
        return new TripResource($item);
    }

    public function create($data = [])
    {
        $userService = app(UserService::class);
        $storeService = app(StoreService::class);
        $destination = [];
        $userCompany = $userService->findUserCompany($data['user_id']);

        if ($userCompany->id != $data['company_id']) {
            abort(500, 'User tidak valid');
        }

        $item = new Trip($data);
        $item->save();

        foreach ($data['destination'] as $d) {
            $store = [
                'company_id' => $data['company_id'],
                'name' => $d,
            ];

            $destination[] = [
                'store_id' => $storeService->create($store)->id,
                'trip_id' => $item->id,
            ];
        }

        $item->destinations()->createMany($destination);
        return $item;
    }

    public function update($data = [], $id)
    {
        $storeService = app(StoreService::class);
        $destination = [];
        $item = Trip::where('company_id', $data['company_id'])->findOrFail($id);
        $item->update($data);

        if (array_key_exists('destination', $data)) {
            foreach ($data['destination'] as $d) {
                $store = [
                    'company_id' => $data['company_id'],
                    'name' => $d,
                ];

                $destination[] = [
                    'store_id' => $storeService->create($store)->id,
                    'trip_id' => $item->id
                ];
            }

            $item->destinations()->delete();
            $item->destinations()->createMany($destination);
        }
    }

    public function delete($companyId, $id)
    {
        $item = Trip::where('company_id', $companyId)->findOrFail($id);
        $item->delete();
    }
}
