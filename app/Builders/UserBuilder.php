<?php

declare(strict_types=1);

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use Modules\Users\Enums\Statuses;

class UserBuilder extends Builder
{
    /**
     * @param Statuses $status
     * @return self
     */
    public function whereStatus(Statuses $status): self
    {
        return $this->where('status', $status);
    }

    /**
     * @param string $firstName
     * @param bool $strict
     * @return self
     */
    public function whereFirstName(string $firstName, bool $strict = false): self
    {
        return $strict
            ? $this->where('first_name', $firstName)
            : $this->where('first_name', 'LIKE', '%' . $firstName . '%');
    }

    /**
     * @param string $lastName
     * @param bool $strict
     * @return self
     */
    public function whereLastName(string $lastName, bool $strict = false): self
    {
        return $strict
            ? $this->where('last_name', $lastName)
            : $this->where('last_name', 'LIKE', '%' . $lastName . '%');
    }

    /**
     * @param string $email
     * @param bool $strict
     * @return self
     */
    public function whereEmail(string $email, bool $strict = false): self
    {
        return $strict
            ? $this->where('email', $email)
            : $this->where('email', 'LIKE', '%' . $email . '%');
    }
}
