<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function authenticate($request, array $guards): void
    {
        if (empty($guards)) {
            $guards = ['sanctum'];
        }

        parent::authenticate($request, $guards);
    }

    /**
     * @throws AuthenticationException
     */
    protected function unauthenticated($request, array $guards): void
    {
        throw new AuthenticationException('You are not authenticated.');
    }
}
