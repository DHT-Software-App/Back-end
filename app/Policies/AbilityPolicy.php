<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AbilityPolicy
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

    public function view(User $user, $name) {
        return $user->employee->can("view:{$name}") || $user->employee->isA($name);
    }

    public function create(User $user, $name) {
        return $user->employee->can("create:{$name}");
    }

    public function update(User $user, $name) {
        return $user->employee->can("update:{$name}");
    }

    public function delete(User $user, $name) {
        return $user->employee->can("delete:{$name}");
    }
}
