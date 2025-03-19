<?php

declare(strict_types=1);

namespace Modules\Users\DataTransferObjects;

use App\DataTransferObjects\DataTransferObject;
use App\DataTransferObjects\PaginatorDto;
use Modules\Users\Enums\Statuses;

class UsersIndexRequestDto extends DataTransferObject
{
    public function __construct(
        private(set) readonly Statuses|null $status,
        private(set) readonly string|null   $firstName,
        private(set) readonly string|null   $lastName,
        private(set) readonly string|null   $email,
        private(set) readonly PaginatorDto  $paginatorDto,
    ) {
    }
}
