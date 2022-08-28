<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Repositories\RoleRepository;
use http\Env\Response;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    protected $roleRepo;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepo=$roleRepository;
    }


    public function update($id, UpdateRoleRequest $request)
    {
        try {
            $this->roleRepo->updateRole($id, $request);
            return \response(['message' => 'Cập nhật role thành công!'],200);

        }catch (\Exception $e){
            return \response(['message' => 'Cập nhật role thất bại !'],500);
        }
    }
    public function index()
    {
        return $this->roleRepo->getAll();
    }

    public function store(RoleRequest $request)
    {
        try {
            $this->roleRepo->createRole($request);
            return \response(["message" => "Thêm chức vụ thành công !"],200);

        }catch (\Exception $e) {
            return \response(["message" => "Thêm chức vụ thất bại !"],500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->roleRepo->deleteRole($id);
            return response([
                "message" => "Xoa quyen thanh cong"
            ]);
        }catch (\Exception $e) {
            return response([
                "message" => "Xoa quyen khong thanh cong"
            ]);
        }
    }

}
