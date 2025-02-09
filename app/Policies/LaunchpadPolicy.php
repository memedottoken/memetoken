<?php

namespace App\Policies;

use App\Models\Launchpad;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LaunchpadPolicy
{
    use HandlesAuthorization;
	
	public function before(User $user)
	{
		if ($user->isAdmin()) {
			return true;
		}
	}
	
	 /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('viewany.launchpad');
    }

    /**
     * Determine whether the user can view the DocLaunchpad.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Launchpad  $launchpad
     * @return bool
     */
    public function view(User $user, Launchpad $launchpad): bool
    {
		return $user->hasPermission('view.launchpad');
    }

    /**
     * Determine whether the user can create DocDummyPluralModel.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
		return $user->hasPermission('create.launchpad');
    }

    /**
     * Determine whether the user can update the DocLaunchpad.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Launchpad  $launchpad
     * @return bool
     */
    public function update(User $user, Launchpad $launchpad): bool
    {
        return $user->hasPermission('update.launchpad') || $user->id == $launchpad->user_id;
    }

    /**
     * Determine whether the user can delete the DocLaunchpad.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Launchpad  $launchpad
     * @return bool
     */
    public function delete(User $user, Launchpad $launchpad): bool
    {
        return  $user->hasPermission('delete.launchpad') || $user->id == $launchpad->user_id;
    }

    /**
     * Determine whether the user can restore the DocLaunchpad.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Launchpad  $launchpad
     * @return bool
     */
    public function restore(User $user, Launchpad $launchpad): bool
    {
         return $user->hasPermission('restore.launchpad') || $user->id == $launchpad->user_id;
    }

    /**
     * Determine whether the user can permanently delete the DocLaunchpad.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Launchpad  $launchpad
     * @return bool
     */
    public function forceDelete(User $user, Launchpad $launchpad): bool
    {
        return $user->hasPermission('forcedelete.launchpad') || $user->id == $launchpad->user_id;		
    }
}