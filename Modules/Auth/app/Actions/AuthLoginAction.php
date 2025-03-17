<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\DataTransferObjects\AuthLoginRequestDto;
use Modules\Auth\DataTransferObjects\BearerTokenDto;

class AuthLoginAction
{
    /**
     * @throws AuthenticationException
     */
    public function execute(AuthLoginRequestDto $dto): BearerTokenDto
    {
        $this->loginUser($dto);

        /** @var User $user */
        $user = Auth::user();

        $this->eliminateUserExistingTokens($user);
        $expiresAt = $this->getExpirationDate();

        return new BearerTokenDto(
            token: $this->createToken($user, $expiresAt),
            expiresAt: $expiresAt->toDateTimeString(),
            user: $user
        );
    }

    /**
     * @throws AuthenticationException
     */
    private function loginUser(AuthLoginRequestDto $dto): void
    {
        if (! Auth::attempt($dto->toArray())) {
            throw new AuthenticationException('The given credentials are invalid');
        }
    }

    private function eliminateUserExistingTokens(User $user): void
    {
        $user->tokens()->delete();
    }

    private function getExpirationDate(): Carbon
    {
        /** @var int $timeForExpiringInMinutes */
        $timeForExpiringInMinutes = config('sanctum.expiration');
        return Carbon::now()->addMinutes($timeForExpiringInMinutes);
    }

    private function createToken(User $user, Carbon $expiresAt): string
    {
        return $user->createToken(
            name: 'authToken',
            expiresAt: $expiresAt
        )->plainTextToken;
    }
}
