<?php

declare(strict_types=1);

namespace App\Services;

use BackedEnum;
use Modules\Users\Enums\UserPermissions;

final readonly class PermissionCollector
{
    /**
     * @return array<BackedEnum>
     */
    public static function all(): array
    {
        return array_merge(...self::getPermissionEnums());
    }

    /**
     * @return array<array<BackedEnum>>
     */
    private static function getPermissionEnums(): array
    {
        return [
            UserPermissions::cases(),
        ];
    }
}
