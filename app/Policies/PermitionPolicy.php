<?php

namespace Corp\Policies;

use Corp\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermitionPolicy
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

    public function change(User $user)
    {
        //php artisan make:policy PermitionPolicy
        //AuthServiceProvider 'Corp\Permition' => 'Corp\Policies\PermitionPolicy',
        return $user->canDo('EDIT_PERMITION');
    }
}
