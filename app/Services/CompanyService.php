<?php

namespace App\Services;

use App\Http\Resources\Company as CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
// use Image;

class CompanyService
{
    public function __construct()
    {
        # code...
    }

    public function find($id)
    {
        $item = Company::findOrFail($id);
        return new CompanyResource($item);
    }

    public function create($data = [])
    {
        // $img = Image::make(public_path('images/sample.jpg'));
        // $img->text($data['name'][0], 50, 80, function ($font) {
        //     $font->size(100);
        //     $font->color('#fff');
        // });
        // $img->resize(200, 200);
        // $path = public_path('images/company/' . str_slug($data['name']));
        // \File::makeDirectory($path, $mode = 0777, true, true);
        // $img->save($path . '/default.jpg');

        $item = new Company($data);
        $item->save();
        return $item;
    }

    public function update($data = [], $id)
    {
        $item = Company::findOrFail($id);
        $item->slug = null;
        $item->update($data);
    }

    public function signup($user, $companyName)
    {
        $locationService = app(LocationService::class);
        $departmentService = app(DepartmentService::class);
        $jobTitleService = app(JobTitleService::class);
        $roleService = app(RoleService::class);

        $companyFields = [
            'name' => $companyName,
        ];
        $company = $this->create($companyFields);

        $locationFields = [
            'company_id' => $company->id,
            'name' => 'Kantor Pusat'
        ];
        $location = $locationService->create($locationFields);

        $departmentFields = [
            'company_id' => $company->id,
            'location_id' => $location->id,
            'name' => 'General'
        ];
        $department = $departmentService->create($departmentFields);

        $jobTitleFields = [
            'company_id' => $company->id,
            'location_id' => $location->id,
            'department_id' => $department->id,
            'name' => 'Admin'
        ];
        $jobTitle = $jobTitleService->create($jobTitleFields);

        $user->jobTitles()->attach($jobTitle->id);
        $roleService->createDefault($jobTitle->id);

        return $company;
    }
}
