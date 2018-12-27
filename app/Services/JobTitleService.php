<?php

namespace App\Services;

use App\Http\Resources\JobTitle as JobTitleResource;
use App\Models\JobTitle;
use Illuminate\Http\Request;

class JobTitleService
{
    public function __construct()
    {
        # code...
    }

    public function list($companyId, $departmentId, $perPage = 5)
    {
        $items = JobTitle::where('company_id', $companyId);
        $items = $departmentId ? $items->where('department_id', $departmentId) : $items;
        $items = $perPage == 'all' ? $items->get() : $items->paginate((int)$perPage);
        return JobTitleResource::collection($items);
    }

    public function find($companyId, $id)
    {
        $item = JobTitle::where('company_id', $companyId)->findOrFail($id);
        return new JobTitleResource($item);
    }

    public function create($data = [])
    {
        $item = new JobTitle($data);
        $item->save();

        if (array_key_exists('roles', $data)) {
            foreach ($data['roles'] as $k => $r) {
                $data['roles'][$k]['module_id'] = $k + 1;
                $data['roles'][$k]['job_title_id'] = $item->id;
            }

            $item->roles()->createMany($data['roles']);
        }

        return $item;
    }

    public function update($companyId, $data = [], $id)
    {
        $item = JobTitle::where('company_id', $companyId)->findOrFail($id);
        $item->update($data);

        foreach ($data['roles'] as $k => $r) {
            $where = [
                'module_id' => $k + 1,
                'job_title_id' => $item->id,
            ];
            $role = [
                'list' => $r['list'],
                'detail' => $r['detail'],
                'create' => $r['create'],
                'update' => $r['update'],
                'delete' => $r['delete'],
            ];
            $item->roles()->updateOrCreate($where, $role);
        }
    }

    public function delete($companyId, $id)
    {
        $item = JobTitle::where('company_id', $companyId)->findOrFail($id);
        $item->roles()->delete();
        $item->delete();
    }
}
