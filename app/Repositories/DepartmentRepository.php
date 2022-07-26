<?php

namespace App\Repositories;

use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentRepository extends BaseRepository
{

    public function __construct(Department $model)
    {
        parent::__construct($model);
    }

    public function createDepartment($request)
    {
        DB::beginTransaction();
        try {
            $fillData = $this->model->fill($request->all());
            $this->create($fillData->toArray());
            DB::commit();
        }catch (Exception $e)
        {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

    }

    public function updateDepartment($request , $id)
    {
        $fillData = $this->model->fill($request->all());
        $this->update($id,$fillData->toArray());
    }

    public function deleteDepartment($id)
    {
        DB::beginTransaction();
        try {
            $department = $this->find($id);
            $department->users()->sync(0);
            $department->users()->detach(0);
            $department->delete();
            DB::commit();
        }catch (Exception $e)
        {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

    }

}
