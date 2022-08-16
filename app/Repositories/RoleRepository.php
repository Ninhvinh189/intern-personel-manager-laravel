<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoleRepository extends BaseRepository
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function createRole($request)
    {
        DB::beginTransaction();
        try {
            $param = [
              'name' => $request->name,
              'description' => $request->description
            ];
            $role = $this->model->fill($param);
            $this->create($role->toArray());
            DB::commit();
        }catch (Exception $e)
        {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function updateRole($id, $request)
    {
        $param = [
            'name' => $request->name,
            'description' => $request->description
        ];
        $fillData = $this->model->fill($param);
        $this->update($id,$fillData->toArray());
    }

    public function deleteRole($id)
    {
        DB::beginTransaction();
        try {
            $role = $this->find($id);
            $role->users()->sync(0);
            $role->users()->detach(0);
            $role->delete();
            DB::commit();
        }catch (Exception $e)
        {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

}

