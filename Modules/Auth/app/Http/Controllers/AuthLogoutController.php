<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Actions\AuthLogoutAction;

class AuthLogoutController
{
    public function __invoke(
        Request $request,
        AuthLogoutAction $authLogoutAction
    ): Response
    {
        /** @var User $user */
        $user = Auth::user();
        $authLogoutAction->execute($user);

        return response()->noContent();
    }
}
