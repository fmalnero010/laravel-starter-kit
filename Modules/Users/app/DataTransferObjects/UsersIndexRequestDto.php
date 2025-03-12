<?php

declare(strict_types=1);

namespace Modules\Users\DataTransferObjects;

use App\DataTransferObjects\DataTransferObject;
use Modules\Users\Enums\Statuses;

readonly class UsersIndexRequestDto extends DataTransferObject
{
    public function __construct(
        private(set) Statuses|null $status,
        private(set) string|null   $firstName,
        private(set) string|null   $lastName,
        private(set) string|null   $email,
    ) {
    }
}
