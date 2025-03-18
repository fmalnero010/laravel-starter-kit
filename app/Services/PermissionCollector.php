<?php

declare(strict_types=1);

namespace App\Services;

use Modules\Users\Enums\UserPermissions;
use UnitEnum;

final readonly class PermissionCollector
{
    /**
     * @return array<UnitEnum>
     */
    public static function all(): array
    {
        return array_merge(...self::getPermissionEnums());
    }

    /**
     * @return array<array<UnitEnum>>
     */
    private static function getPermissionEnums(): array
    {
        return [
            UserPermissions::cases(),
        ];
    }
}
