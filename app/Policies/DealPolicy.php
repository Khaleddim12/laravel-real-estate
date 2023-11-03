<?php

namespace App\Policies;

use App\Models\Deal;
use App\Models\Estate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->role->name === "Administrator") {
            return true;
        }
    }


    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return checkPermission("view:deal", $user->role->permissions, $user) ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Deal $deal)
    {
        $estate = Estate::where("id", $deal->estate_id)->first();

        return checkPermission("show:deal", $user->role->permissions, $user, model:($deal->user_id === $user->id || $estate->user_id === $user->id ) ? true : false) ? true : false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return checkPermission("write:deal", $user->role->permissions, $user) ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Deal $deal)
    {
        $estate = Estate::where("id", $deal->estate_id)->first();

        return checkPermission("update:deal", $user->role->permissions, $user, model:($deal->user_id === $user->id || $estate->user_id === $user->id ) ? true : false) ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Deal $deal)
    {
        $estate = Estate::where("id", $deal->estate_id)->first();

        return checkPermission("delete:deal", $user->role->permissions, $user, model:($deal->user_id === $user->id || $estate->user_id === $user->id ) ? true : false) ? true : false;
    }


}
