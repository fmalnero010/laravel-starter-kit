<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthApiMiddleware extends Authenticate
{
    /**
     * @throws HttpException
     */
    protected function unauthenticated($request, array $guards): void
    {
        throw new HttpException(Response::HTTP_UNAUTHORIZED, 'You are not authenticated.');
    }
}
