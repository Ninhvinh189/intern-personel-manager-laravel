<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDepartment;
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

    public function getListUserDepartment($id)
    {
        $departmentId = $this->find($id)->departments()->first()->id;
        return Department::find($departmentId)->users()->with('profile','roles','departments')->get();

    }

    public function findUser($id)
    {
        return User::with('profile','departments','roles')->find($id);
    }

    public function updateUser($request, $id)
    {
        DB::beginTransaction();
        try{
            $this->updateProfileUser($request, $id);
            $this->updateRoleUser($request, $id);
            $this->updateDepartmentUser($request, $id);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

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
                $this->updateNumberMemberDeparment($request->department);
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

            $user->profile()->updateOrCreate(
                [
                    'user_id' => $id
                ], [
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
                'description' => $request->description
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    protected function updateNumberMemberDeparment($id)
    {
        $numberMember = $this->countMemberDepartment($id);
        $newDepartment = Department::query()->find($id);
        $newDepartment->number_of_member = count($numberMember);
        $newDepartment->save();
    }

    public function updateDepartmentUser($request, $id)
    {
        DB::beginTransaction();
        try {
            $user = $this->findUser($id);
            $presentDepartment = $user->departments->first();
            $user->departments()->sync($request->department);
            $this->updateNumberMemberDeparment($request->department);
            if ($presentDepartment !== null){
                $this->updateNumberMemberDeparment($presentDepartment->id);
            }
            DB::commit();
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
            $user->roles()->sync($request->role);
            DB::commit();
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
            if ($user->roles()->first()->name === 'admin'){
                throw new \Exception();
            }
            $department = $user->departments()->first();
            if ($department !== null){
                $user->departments()->detach();
                $this->updateNumberMemberDeparment($department->id);
            }
            $user->profile()->delete();
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
        return $departmentAuth->id == $department->id;
    }

}
