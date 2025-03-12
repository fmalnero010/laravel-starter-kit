<?php

declare(strict_types=1);

namespace Modules\Users\Enums;

enum Statuses: string
{
    case ACTIVE   = 'A';
    case INACTIVE = 'I';
    case PENDING  = 'P';
}
