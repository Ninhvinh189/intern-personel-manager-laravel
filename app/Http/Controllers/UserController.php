<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDepartmentUserRequest;
use App\Http\Requests\UpdateRoleUserRequest;
use App\Http\Requests\UserProfileRequest;

use App\Http\Requests\UserRequest;
use App\Models\Department;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
        $this->authorizeResource(User::class,'user');
    }

    public function index()
    {
        return $this->userRepo->getListUser();
    }

    public function findUser($id)
    {
        try {
            return $this->userRepo->findUser($id);
        } catch (\Exception $e)
        {
            return response([
                "status" => 500
            ]);
        }
    }

    public function createUser(UserRequest $request)
    {
//        dd($request->all());
        try{
            $this->userRepo->createUser($request);
            return response([
                "status" => 200,
                "message"=>"Them nhan vien thanh cong"
            ]);
        } catch (\Exception $e) {
            return response([
               "status" => 500,
                "message" => "Them nhan vien that bai"
            ]);
        }

    }

    public function updateProfile(UserProfileRequest $request, $id)
    {
        $user_res = $this->userRepo->find($id);
        $leader = $this->userRepo->checkLeaderUser($id);

        $this->authorize('updateProfileUserPolicy', [$user_res,$leader]);

        try {
            $this->userRepo->updateProfileUser($request, $id);
            return response([
               "message" => "update thanh cong"
            ]);
        } catch (\Exception $e) {
            return response([
                "message" =>" update that bai"
            ]);
        }
    }

    public function updateAvatar(Request  $request, $id)
    {
        try {
            $this->userRepo->updateAvatar($request,$id);
            return response([
                "message" => "Cap nha avatar thanh cong"
            ]);
        }catch (\Exception $e) {
            return response([
               "message" => "Cap nhat avatar that bai"
            ]);
        }
    }

    public function updateDepartment(UpdateDepartmentUserRequest $request, $id)
    {
        $this->authorize('updateDepartmentPolicy', User::class);
        try {
            $this->userRepo->updateDepartmentUser($request,$id);
            return response([
                "message" => "update thanh cong"
            ]);
        } catch (\Exception $e) {
            return response([
                "message" => "update that bai"
            ]);
        }
    }

    public function updateRole(UpdateRoleUserRequest $request, $id)
    {
        $this->authorize('updateRoleUserPolicy', User::class);
        try {
            $this->userRepo->updateRoleUser($request,$id);
            return response([
                "message" => "Them quyen thanh cong"
            ]);
        }catch (\Exception $e) {
            return response([
                "message" => "Them quyen that bai"
            ]);
        }

    }

    public function destroyUser($id)
    {

        $leader = $this->userRepo->checkLeaderUser($id);

        $this->authorize('deleteUserPolicy', [User::class, $leader]);

        try {
            $this->userRepo->deleteUser($id);
            return response([
                "message" => "Xoa thanh cong"
            ]);
        } catch (\Exception $e)
        {

        }

    }

}
