<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return bool
     */


    public function view(User $user)
    {

        dd(2);
    }
    public function create(User $user)
    {
        return auth()->user()->roles()->first()->name == 'admin';
    }

    public function delete(User $user, User $model)
    {
        dd(1);
    }
}
