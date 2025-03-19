<?php

namespace Modules\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Enums\UserPermissions;
use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function index(User $user): bool
    {
        return $user->hasPermissionTo(UserPermissions::UsersIndex);
    }
}
