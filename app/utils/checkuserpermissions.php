<?php
use App\Models\User;
/**
 * Check user's permissions
 *
 * @param  string  $policy
 * @param  \Illuminate\Database\Eloquent\Collection  $userPermissions
 * @param  \App\Models\User  $user
 * @param  \Illuminate\Database\Eloquent\Model|null  $model
 * @param  \Illuminate\Database\Eloquent\Model|null  $user_model
 * @return bool
 */
if (!function_exists("checkPermission")) {
    function checkPermission($policy, $userPermissions, User $user, $model = null, $user_model = null)
    {
        [$action, $resource] = explode(':', $policy);

        foreach ($userPermissions as $permission) {
            if ($permission->action === $action && $permission->resource === $resource) {
                if ($model !== null && $model !== true) {
                    // Deny access if the user does not own the model
                    return false;
                }

                if ($user_model !== null && $user->type === $user_model->user->type && $user->id !== $user_model->user->id) {
                    // Deny access if the user does not have the correct type and does not match the user model
                    return false;
                }

                // Allow access if the user meets the required conditions
                return true;
            }
        }

        // Deny access if there's no matching permission
        return false;
    }
}


