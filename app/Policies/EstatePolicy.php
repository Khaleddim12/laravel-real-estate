<?php

namespace App\Policies;

use App\Models\Estate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstatePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->role->name === "Administrator") {
            return true;
        }
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return checkPermission("write:estate", $user->role->permissions, $user) ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Estate $estate)
    {
        return checkPermission("update:estate", $user->role->permissions, $user, model:$estate->user_id === $user->id ? true : false);

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Estate $estate)
    {
        return checkPermission("delete:estate", $user->role->permissions, $user, model:$estate->user_id === $user->id ? true : false) ? true : false;

    }
}
