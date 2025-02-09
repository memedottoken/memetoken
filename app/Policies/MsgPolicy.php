<?php

namespace App\Policies;

use App\Models\Msg;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MsgPolicy
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
        return $user->hasPermission('viewany.msg');
    }

    /**
     * Determine whether the user can view the DocMsg.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Msg  $msg
     * @return bool
     */
    public function view(User $user, Msg $msg): bool
    {
		return $user->hasPermission('view.msg');
    }

    /**
     * Determine whether the user can create DocDummyPluralModel.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
		return $user->hasPermission('create.msg');
    }

    /**
     * Determine whether the user can update the DocMsg.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Msg  $msg
     * @return bool
     */
    public function update(User $user, Msg $msg): bool
    {
        return $user->hasPermission('update.msg') || $user->id == $msg->user_id;
    }

    /**
     * Determine whether the user can delete the DocMsg.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Msg  $msg
     * @return bool
     */
    public function delete(User $user, Msg $msg): bool
    {
        return  $user->hasPermission('delete.msg') || $user->id == $msg->user_id;
    }

    /**
     * Determine whether the user can restore the DocMsg.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Msg  $msg
     * @return bool
     */
    public function restore(User $user, Msg $msg): bool
    {
         return $user->hasPermission('restore.msg') || $user->id == $msg->user_id;
    }

    /**
     * Determine whether the user can permanently delete the DocMsg.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Msg  $msg
     * @return bool
     */
    public function forceDelete(User $user, Msg $msg): bool
    {
        return $user->hasPermission('forcedelete.msg') || $user->id == $msg->user_id;		
    }
}