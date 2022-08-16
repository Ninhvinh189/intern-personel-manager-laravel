<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use http\Env\Request;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Pipeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mockery\Exception;
use PharIo\Manifest\ElementCollectionException;
use function PHPUnit\Framework\throwException;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findUser($id)
    {
        return User::with('profile','departments','roles')->find($id);
    }

    public function createUser($request)
    {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->firstName = $request->input('firstName');
            $user->lastName = $request->input('lastName');
            $user->email = $request->email;
            $user->password = Hash::make($request->input('password'));
            $user->save();

            $path = $this->addAvatar($request);

            $checkDepartmentExist = Department::where('id', '=', $request->department)->exists();
            $checkRoleExist = Role::where('id', '=', $request->role)->exists();
            if ($checkDepartmentExist && $checkRoleExist) {
                $user->departments()->sync($request->department);
                $user->roles()->sync($request->role);
            }
            $user->profile()->updateOrCreate(
                [
                    'user_id' => auth()->id()
                ], [
                'phone' => $request->phone,
                'avatar' => $path,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
                'description' => $request->description
            ]);

            $this->countMemberDepartment($request->department);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        } catch (\Exception $e) {

        }
    }

    protected function countMemberDepartment($id){
        return DB::table('user_department')->where('department_id', $id)->get();
    }

    public function getListUser()
    {
        return User::with('profile', 'departments','roles')->get();
    }

    public function addAvatar($request)
    {
        $file = $request->avatar;
        if($file == null){
            return "default";
        }
        $newFile = Str::uuid($file->getClientOriginalName());
        $path = $newFile . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $path);
        return $path;
    }

    public function updateAvatar($request, $id)
    {
        $path = $this->addAvatar($request);
        $user = $this->model->find($id)->load('profile');
        $user->profile()->updateOrCreate(
            [
                'user_id' => $id
            ], [
            'avatar' => $path,
        ]);
    }

    public function updateProfileUser($request, $id)
    {
        DB::beginTransaction();
        try {
            $user = $this->model->find($id)->load('profile');
            $user->firstName = $request->input('firstName');
            $user->lastName = $request->input('lastName');
            $user->save();
            $path = $this->addAvatar($request);
            $checkPhoneExist = Profile::where('phone', '=', $request->phone,'and','id','!=',$id)->exists();

            if(!$checkPhoneExist){
                $user->profile()->updateOrCreate(
                    [
                        'user_id' => $id
                    ], [
                    'phone' => $request->phone,
                    'avatar' => $path,
                    'date_of_birth' => $request->date_of_birth,
                    'address' => $request->address,
                    'description' => $request->description
                ]);
                DB::commit();
            }else{
                throw new \Exception();
            }

        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function updateDepartmentUser($request, $id)
    {

        DB::beginTransaction();
        try {
            $user = $this->find($id);
            $checkDepartmentExist = Department::where('id', '=', $request->department)->exists();
            if ($checkDepartmentExist) {
                $user->departments()->sync($request->department);
                $numberMember = $this->countMemberDepartment($request->department);
                $department = new Department();
                $param = [
                    'number_of_member' => count($numberMember)
                ];
                $fillData = $department->fill($param);
                $department->update($request->department,$fillData->toArray());
                DB::commit();
            } else {
                throw new \Exception();
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function updateRoleUser($request, $id)
    {
        DB::beginTransaction();
        try {
            $user = $this->find($id);
            if (Role::where('id', '=', $request->role)->exists()) {
                $user->roles()->sync($request->role);
                DB::commit();
            } else {
                throw new \Exception();
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

    }

    public function deleteUser($id)
    {

        DB::beginTransaction();
        try {
            $user = $this->find($id);
            $user->profile()->delete();
            $user->departments()->detach();
            $user->roles()->detach();
            $user->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

    }

    public function checkLeaderUser($id)
    {
        $department = $this->find($id)->departments()->first();
        $departmentAuth = auth()->user()->departments()->first();
        if($departmentAuth == null || $department == null)
        {
            return false;
        }
        return $departmentAuth->id == $department;
    }

}
