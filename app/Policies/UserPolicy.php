<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $check = $user->roles()->first();
        return $check->name == 'admin';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {

    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        dd(1);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }

    public function updateDepartmentPolicy(User $user)
    {
        $check = $user->roles()->first();
        if($check !== null)
        {
            return $check->name == 'admin';
        }
        return false;
    }

    public function updateRoleUserPolicy(User $user)
    {
        $check = $user->roles()->first();
        return $check->name == 'admin';
    }

    public function updateProfileUserPolicy(User $user, User $user_res, $leader)
    {
        $role_user = $user->roles()->first();
        if ($role_user->name == "user")
        {
            return $user->id == $user_res->id;
        } else if ($role_user->name == "leader" && $leader==true)
        {
            return true;
        }
        return $user->name == "admin";
    }

    public function deleteUserPolicy(User $user, $id, $leader)
    {
        $check = $user->roles()->first();
        if ($check->name == 'leader' && $leader==true)
        {
            return true;
        }

        return $check->name == 'admin';
    }
}
