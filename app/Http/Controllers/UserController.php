<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return $this->userRepo->getAll();
    }

    public function updateProfile(Request $request, $id)
    {
        $this->userRepo->findLeaderUser($id);

        $user_res = $this->userRepo->find($id);
        $leader = $this->userRepo->checkLeaderUser($id);

        $this->authorize('updateProfileUserPolicy', [$user_res,$leader]);

        try {
            $this->userRepo->updateProfileUser($request, $id);

            return response([
               "message" => "update thanh cong"
            ]);
        } catch (\Exception $e)
        {
            return response([
                "message"=>"update that bai",
                "status"=>500
            ]);
        }
    }

    public function updateDepartment(Request $request, $id)
    {

        $this->authorize('updateDepartmentPolicy', User::class);
        try {
            $this->userRepo->updateDepartmentUser($request,$id);
            return response([
                "message" => "update thanh cong"
            ]);
        } catch (\Exception $e)
        {
            return response([
                "message"=>"update that bai",
                "status"=>500
            ]);
        }
    }

    public function updateRole(Request $request, $id)
    {
        $this->authorize('updateRoleUserPolicy', User::class);

        try {
            $this->userRepo->updateRoleUser($request,$id);
        }catch (\Exception $e)
        {

        }

    }

    public function destroyUser($id)
    {
        try {
            $leader = $this->userRepo->checkLeaderUser($id);
            $this->authorize('deleteUserPolicy',[$id, $leader]);
            $this->userRepo->deleteUser($id);
            return response([
                "message" => "Xoa thanh cong"
            ]);
        } catch (\Exception $e)
        {

        }

    }

}
