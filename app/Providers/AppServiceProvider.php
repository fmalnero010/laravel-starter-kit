<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use L5Swagger\L5SwaggerServiceProvider;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Response::macro('success', function ($data = [], int $status = HttpResponse::HTTP_OK) {
            if (is_null($data)) {
                return response()->noContent();
            }

            return response()->json([
                'status' => 1,
                'message' => 'SUCCESS',
                'data' => $data,
            ], $status);
        });

        Response::macro('error', function ($data = [], int $status = HttpResponse::HTTP_BAD_REQUEST) {
            if (is_null($data)) {
                return response()->noContent();
            }

            return response()->json([
                'status' => -1,
                'message' => 'ERROR',
                'data' => $data,
            ], $status);
        });
    }

    public function register(): void
    {
        $this->app->register(L5SwaggerServiceProvider::class);
    }
}
