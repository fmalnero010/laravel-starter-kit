<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects;

use App\DataTransferObjects\DataTransferObject;
use App\Models\User;

class BearerTokenDto extends DataTransferObject
{
    private(set) readonly string $tokenType;

    public function __construct(
        private(set) readonly string $token,
        private(set) readonly string $expiresAt,
        private(set) readonly User $user
    ) {
        $this->tokenType = 'Bearer';
    }
}
