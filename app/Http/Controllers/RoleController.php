<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
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
//        $this->authorizeResource(Role::class);
    }

//    protected function resourceAbilityMap(): array
//    {
//        return array_merge(parent::resourceAbilityMap(), [
//            'index' => 'view',
//            'store' => 'create',
//            'destroy' => 'delete',
//        ]);
//    }

    public function update($id, RoleRequest $request)
    {
        try {
            $this->roleRepo->updateRole($id, $request);
            return response([
               'status' => 200,
               'message' => 'Update quyen thanh cong'
            ]);
        }catch (\Exception $e){
            return response([
                'status' => 500,
                'message' => 'Update quyen that bai'
            ]);
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
            return response([
               "message" => "Them quyen thanh cong"
            ]);
        }catch (\Exception $e) {
            return response([
               "message" => "Tao quyen khong thanh cong"
            ]);
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
