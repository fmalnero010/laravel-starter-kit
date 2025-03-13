<?php

declare(strict_types=1);

namespace Modules\Users\Transformers;

use App\Transformers\PaginatorResource;

class UserPaginatorResource extends PaginatorResource
{
    protected function resourceClass(): string
    {
        return UserResource::class;
    }
}
