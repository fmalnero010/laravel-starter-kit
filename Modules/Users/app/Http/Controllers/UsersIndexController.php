<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Users\Actions\UsersIndexAction;
use Modules\Users\Http\Requests\UsersIndexRequest;
use Modules\Users\Transformers\UserPaginatorResource;

class UsersIndexController
{
    public function __invoke(
        UsersIndexRequest $usersIndexRequest,
        UsersIndexAction $usersIndexAction,
    ): JsonResponse {
        $users = $usersIndexAction->execute($usersIndexRequest->toDto());

        return response()->success(
            new UserPaginatorResource($users),
        );
    }
}
