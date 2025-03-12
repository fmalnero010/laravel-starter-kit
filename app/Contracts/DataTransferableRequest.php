<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DataTransferObjects\DataTransferObject;

interface DataTransferableRequest
{
    public function toDto(): DataTransferObject;
}
