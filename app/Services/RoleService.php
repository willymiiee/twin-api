<?php

namespace App\Services;

use App\Models\Module;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleService
{
    public function __construct()
    {
        # code...
    }

    public function create($data = [])
    {
        $item = new Role($data);
        $item->save();
        return $item;
    }

    public function createDefault($jobTitleId)
    {
        $modules = Module::get();

        foreach ($modules as $m) {
            $item = new Role([
                'job_title_id' => $jobTitleId,
                'module_id' => $m->id,
                'list' => True,
                'detail' => True,
                'create' => True,
                'update' => True,
                'delete' => True
            ]);

            $item->save();
        }
    }
}
