<?php

namespace Corp\Policies;

use Corp\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function save(User $user)
    {
        return $user->canDo('EDIT_MENU');
    }

    public function update(User $user)
    {
        return $user->canDo('UPDATE_MENU');
    }
    public function delete(User $user)
    {
        return $user->canDo('DELETE_MENU');
    }
}
