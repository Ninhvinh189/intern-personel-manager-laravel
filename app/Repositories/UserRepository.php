<?php

namespace App\Repositories;

use App\Models\User;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function updateProfileUser($request, $id)
    {

        DB::beginTransaction();
        try{
            $user = $this->model->find($id)->load('profile');
            $user->name =  $request->input('firstName').''.$request->input('lastName');
            $user->save();

            $file = $request->avatar;

            $newFile = Str::uuid($file->getClientOriginalName());

            $path = $newFile.'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images'),$path);

            $user->profile()->updateOrCreate(
                [
                    'user_id'=> $id
                ], [
                'phone'=>$request->phone,
                'avatar' => $path,
                'date_of_birth'=>$request->date_of_birth,
                'address' => $request->address,
                'description'=>$request->description
            ]);

            DB::commit();

        }catch (Exception $e)
        {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function updateDepartmentUser($request, $id)
    {
        DB::beginTransaction();
        try{
            $user = $this->find($id);
            $user->departments()->sync($request->department);
            DB::commit();
        }catch (Exception $e)
        {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function updateRoleUser($request, $id)
    {

        DB::beginTransaction();
        try{
            $user = $this->find($id);
            $user->roles()->sync($request->role);
            DB::commit();
        }catch (Exception $e)
        {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

    }

    public function deleteUser($id)
    {
        DB::beginTransaction();
        try{
            $user = $this->find($id);
            $user->profile()->delete();
            $user->departments()->detach();
            $user->roles()->detach();
            $user->delete();
            DB::commit();
        }catch (Exception $e)
        {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

    }


    public function checkLeaderUser($id)
    {

        $department =  $this->find($id)->departments()->first();
        $departmentAuth = auth()->user()->departments()->first();
        return $departmentAuth->id == $department->id;
    }

}
