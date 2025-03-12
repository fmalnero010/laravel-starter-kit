<?php

declare(strict_types=1);

namespace Modules\Users\Actions;

use App\Builders\UserBuilder;
use App\Models\User;
use Illuminate\Support\Collection;
use Modules\Users\DataTransferObjects\UsersIndexRequestDto;

class UsersIndexAction
{
    /**
     * @return Collection<User>
     */
    public function execute(UsersIndexRequestDto $dto): Collection
    {
        return User::query()
            ->when(
                filled($dto->status),
                static fn (UserBuilder $query): UserBuilder => $query->whereStatus($dto->status)
            )
            ->when(
                filled($dto->firstName),
                static fn (UserBuilder $query): UserBuilder => $query->whereFirstName($dto->firstName)
            )
            ->when(
                filled($dto->lastName),
                static fn (UserBuilder $query): UserBuilder => $query->whereLastName($dto->lastName)
            )
            ->when(
                filled($dto->email),
                static fn (UserBuilder $query): UserBuilder => $query->whereEmail($dto->email)
            )
            ->get();
    }
}
