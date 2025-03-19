<?php

declare(strict_types=1);

namespace Modules\Users\Actions;

use Carbon\Carbon;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Modules\Users\DataTransferObjects\UsersIndexRequestDto;
use Modules\Users\Models\User;

class UsersIndexAction
{
    private const string CACHE_TAG = 'users_index';

    public function __construct(private readonly CacheRepository $cache) {}

    /**
     * @return Paginator<User>
     */
    public function execute(UsersIndexRequestDto $dto): Paginator
    {
        return $this->cache->tags([self::CACHE_TAG])->remember(
            $this->getCacheKey($dto),
            $this->getCacheLifetime(),
            fn (): Paginator => $this->listUsersWithoutCache($dto)
        );
    }

    private function getCacheKey(UsersIndexRequestDto $dto): string
    {
        return self::CACHE_TAG.'_'.md5(serialize($dto));
    }

    private function getCacheLifetime(): Carbon
    {
        return now()->addMinutes((int) config('cache.default_lifetime'));
    }

    /**
     * @return Paginator<User>
     */
    public function listUsersWithoutCache(UsersIndexRequestDto $dto): Paginator
    {
        return User::query()
            ->when(
                filled($dto->status),
                static fn (Builder $query, bool $value): Builder => $query->where('status', $dto->status)
            )
            ->when(
                filled($dto->firstName),
                static fn (Builder $query, bool $value): Builder => $query->where('first_name', $dto->firstName)
            )
            ->when(
                filled($dto->lastName),
                static fn (Builder $query, bool $value): Builder => $query->where('last_name', $dto->lastName)
            )
            ->when(
                filled($dto->email),
                static fn (Builder $query, bool $value): Builder => $query->where('email', $dto->email)
            )
            ->simplePaginate(
                perPage: $dto->paginatorDto->perPage,
                page: $dto->paginatorDto->page,
            );
    }
}
