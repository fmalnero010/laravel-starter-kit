<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Modules\Auth\Actions\AuthLoginAction;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Http\Requests\AuthLoginRequest;
use Modules\Auth\Transformers\BearerTokenResource;

class AuthLoginController
{
    /**
     * @throws AuthenticationException
     */
    public function __invoke(
        AuthLoginRequest $authLoginRequest,
        AuthLoginAction $authLoginAction,
    ): JsonResponse {
        $response = $authLoginAction->execute($authLoginRequest->toDto());

        return response()->success(
            new BearerTokenResource($response)
        );
    }
}
