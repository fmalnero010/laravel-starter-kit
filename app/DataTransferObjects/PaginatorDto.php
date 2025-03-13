<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

/**
 * @property int $perPage
 * @property int $page
 */
class PaginatorDto extends DataTransferObject
{
    public function __construct(
        private(set) int|null $perPage,
        private(set) int|null $page,
    ) {
        if (blank($this->perPage)) {
            $this->perPage = config('pagination.per_page');
        }

        if (blank($this->page)) {
            $this->page = config('pagination.page');
        }
    }
}
