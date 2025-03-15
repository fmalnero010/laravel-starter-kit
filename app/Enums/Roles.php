<?php

declare(strict_types=1);

namespace App\Enums;

enum Roles: string
{
    case SuperAdmin = 'super-admin';
    case Admin = 'admin';
    case User = 'user';
}
