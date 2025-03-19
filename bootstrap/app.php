<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => Authenticate::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $th, Request $request) {
            $errorCode = match (get_class($th)) {
                AuthenticationException::class => ResponseAlias::HTTP_UNAUTHORIZED,
                ValidationException::class     => ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                default                        => ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
            };

            return response()->error(
                $th->getMessage(),
                $th instanceof \Symfony\Component\HttpKernel\Exception\HttpException
                    ? $th->getStatusCode()
                    : $errorCode,
            );
        });
    })->create();
