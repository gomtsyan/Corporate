<?php

namespace Corp\Policies;

use Corp\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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
        return $user->canDo('ADD_CATEGORY');
    }

    public function edit(User $user)
    {
        return $user->canDo('EDIT_CATEGORY');
    }

    public function destroy(User $user)
    {
        return $user->canDo('EDIT_CATEGORY');
    }
}
