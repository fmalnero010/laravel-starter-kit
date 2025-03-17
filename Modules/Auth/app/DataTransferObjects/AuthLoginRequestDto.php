<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects;

use App\DataTransferObjects\DataTransferObject;

class AuthLoginRequestDto extends DataTransferObject
{
    public function __construct(
        private(set) readonly string $email,
        private(set) readonly string $password
    ) {
    }
}
