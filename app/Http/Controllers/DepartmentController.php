<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Models\User;
use App\Policies\DepartmentPolicy;
use App\Repositories\DepartmentRepository;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Http\Middleware\Authenticate;

class DepartmentController extends Controller
{

    protected $departmentRepo;

    public function __construct(DepartmentRepository $departmentRepo)
    {
        $this->departmentRepo = $departmentRepo;
//        $this->authorizeResource(Department::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->departmentRepo->getAll();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        try {
            $this->departmentRepo->createDepartment($request);
            return response([
                "message" => "Thêm phòng ban thành công",
                "status" => "201"
            ]);
        } catch (\Exception $e)
        {
            return response([
                "message" => "Không thành công !",
                "status" => "500"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateDepartmentRequest $request, $id)
    {
        try {
            $this->departmentRepo->updateDepartment($request, $id);
            return response([
                "message" => "Cập nhật thông tin phòng ban thành công",
                "status" => "201"
            ]);
        }catch (\Exception $e)
        {
            return response([
                "message"=>"Cập nhật không thành công",
                "status"=>"500"
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->departmentRepo->deleteDepartment($id);
            return response([
               "message" => "Xoa phong ban thanh cong"
            ]);
        }catch (\Exception $e)
        {
            return response([
                "message"=>"Xoa phong ban that bai"
            ]);
        }
    }

//    public function updateDepartment(UpdateDepartmentRequest $request, $id, Department $department)
//    {
//        $this->authorize('updateDepartmentPolicy', $department);
//
//        try {
//            $this->departmentRepo->updateDepartment($request, $id);
//            return response([
//                "message" => "Cập nhật thông tin phòng ban thành công",
//                "status" => "201"
//            ]);
//        }catch (\Exception $e)
//        {
//            return response([
//                "message"=>"Cập nhật không thành công",
//                "status"=>"500"
//            ]);
//        }
//    }

}
