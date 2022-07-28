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

}

