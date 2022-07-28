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

    protected function resourceAbilityMap()
    {
        return array_merge(parent::resourceAbilityMap(), [
            'index' => 'view',
            'store' => 'create',
            'destroy' => 'delete',
        ]);
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
            $this->roleRepo->delete($id);
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
