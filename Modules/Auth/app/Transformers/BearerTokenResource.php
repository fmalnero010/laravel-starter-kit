<?php

namespace Modules\Auth\Transformers;

use App\Transformers\BaseResource;
use Illuminate\Http\Request;
use Modules\Auth\DataTransferObjects\BearerTokenDto;
use Modules\Users\Transformers\UserResource;

class BearerTokenResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        /** @var BearerTokenDto $dto */
        $dto = $this->resource;

        return [
            'accessToken' => $dto->token,
            'tokenType' => $dto->tokenType,
            'expiresAt' => $dto->expiresAt,
            'user' => UserResource::make($dto->user),
        ];
    }
}
