<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class AuthLogoutAction
{
    public function execute(User $user): void
    {
        /** @var PersonalAccessToken $token */
        $token = $user->currentAccessToken();
        $token->delete();
    }
}
