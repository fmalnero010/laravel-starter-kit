<?php

namespace App\Providers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use L5Swagger\L5SwaggerServiceProvider;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Response::macro(
            'success',
            fn ($data = [], int $status = HttpResponse::HTTP_OK): JsonResponse => $data === null
                    ? response()->json(null, 204)
                    : response()->json([
                        'status' => 1,
                        'message' => 'SUCCESS',
                        'data' => $data,
                    ], $status)
        );

        Response::macro(
            'error',
            fn ($data = [], int $status = HttpResponse::HTTP_BAD_REQUEST): JsonResponse => $data === null
                    ? response()->json(null, 204)
                    : response()->json([
                        'status' => -1,
                        'message' => 'ERROR',
                        'error' => $data,
                    ], $status)
        );

        Response::macro(
            'failedValidation',
            fn ($errors = [], int $status = HttpResponse::HTTP_UNPROCESSABLE_ENTITY): JsonResponse => response()->json([
                'status' => -1,
                'message' => 'ERROR',
                'error' => $errors,
            ], $status)
        );
    }

    public function register(): void
    {
        $this->app->register(L5SwaggerServiceProvider::class);
    }
}
