<?php

namespace App\Services;

use App\Http\Resources\Team as TeamResource;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamService
{
    public function __construct()
    {
        # code...
    }

    public function list($companyId, $perPage = 5)
    {
        $items = Team::where('company_id', $companyId);
        $items = $perPage == 'all' ? $items->get() : $items->paginate((int)$perPage);
        return TeamResource::collection($items);
    }

    public function find($companyId, $id)
    {
        $item = Team::where('company_id', $companyId)->findOrFail($id);
        return new TeamResource($item);
    }

    public function create($data = [])
    {
        $item = Team::firstOrCreate($data);
        $item->save();

        if (array_key_exists('salesman', $data)) {
            foreach ($data['salesman'] as $s) {
                $data = [
                    'code' => $s['code'],
                    'area' => $s['area'],
                ];

                $item->salesmen()->attach($s['id'], $data);
            }
        }

        return $item;
    }

    public function update($data = [], $id)
    {
        $salesmen = [];
        $item = Team::where('company_id', $data['company_id'])->findOrFail($id);
        $item->update($data);

        if (array_key_exists('salesman', $data)) {
            foreach ($data['salesman'] as $s) {
                $salesmen[$s['id']] = [
                    'code' => $s['code'],
                    'area' => $s['area'],
                ];
            }
        }

        $item->salesmen()->sync($salesmen);
    }

    public function delete($companyId, $id)
    {
        $item = Team::where('company_id', $companyId)->findOrFail($id);
        $item->delete();
    }
}
