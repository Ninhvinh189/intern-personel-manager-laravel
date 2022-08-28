<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDepartmentUserRequest;
use App\Http\Requests\UpdateRoleUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserProfileRequest;

use App\Http\Requests\UserRequest;
use App\Models\Department;
use App\Models\User;
use App\Repositories\UserRepository;
use http\Client\Response;
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

    public function getListUserDepartment($id)
    {
       return $this->userRepo->getListUserDepartment($id);
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
        try{
            $this->userRepo->createUser($request);
            return response([
                "status" => 200,
                "message"=>"Thêm nhân viên thành công !"
            ]);
        } catch (\Exception $e) {
            return response([
               "status" => 500,
                "message" => "Bạn đã gặp sự cố !"
            ]);
        }

    }

    public function updateUser(UpdateUserRequest $request, $id)
    {
        $user_res = $this->userRepo->find($id);
        $leader = $this->userRepo->checkLeaderUser($id);

        $this->authorize('updateProfileUserPolicy', [$user_res,$leader]);
        try {
            $this->userRepo->updateUser($request, $id);
            return  response()->json(["message" => "Cập nhật thông tin nhân viên thành công !",],200);
        }catch (\Exception $e){
            return response()->json(["message" => "Cập nhật thông tin thất bại !"],500);
        }
    }

    public function updateProfile(UserProfileRequest $request, $id)
    {
        $user_res = $this->userRepo->find($id);
        $leader = $this->userRepo->checkLeaderUser($id);

        $this->authorize('updateProfileUserPolicy', [$user_res,$leader]);

        try {
            $this->userRepo->updateProfileUser($request, $id);
            return  response()->json(["message" => "Cập nhật thông tin nhân viên thành công !",],200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Cập nhật thông tin thất bại !"],500);
        }
    }

    public function updateAvatar(Request  $request, $id)
    {
        try {
            $this->userRepo->updateAvatar($request,$id);
            return response()->json(["message" => "Cập nhật avatar thành công"],200);
        }catch (\Exception $e) {
            return \response()->json(["message" => "Cập nhật avatar thất bại"],500);

        }
    }

    public function updateDepartment(UpdateDepartmentUserRequest $request, $id)
    {
        $this->authorize('updateDepartmentPolicy', User::class);
        try {
            $this->userRepo->updateDepartmentUser($request,$id);
            return \response()->json(["message" => "Cập nhật phòng ban người dùng thành công"],200);
        } catch (\Exception $e) {
            return \response()->json(["message" => "Cập nhật phòng ban người dùng thất bại"],500);
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

        $user_res = $this->userRepo->find($id);
        $leader = $this->userRepo->checkLeaderUser($id);

        $this->authorize('updateProfileUserPolicy', [$user_res,$leader]);

        try {
            $this->userRepo->deleteUser($id);
            return \response(["message" => "Xóa nhân viên thành công"],200);
        } catch (\Exception $e)
        {
            return \response(["message" => "Gặp sự cố khi xóa người dùng"],500);
        }

    }

}
