<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests;

use App\Contracts\DataTransferableRequest;
use App\Http\Requests\APIRequest;
use App\Rules\AlphaNumSpaces;
use Modules\Auth\DataTransferObjects\AuthLoginRequestDto;

class AuthLoginRequest extends APIRequest implements DataTransferableRequest
{
    public const string EMAIL = 'email';

    public const string PASSWORD = 'password';

    public function rules(): array
    {
        return [
            self::EMAIL => ['required', 'email:strict'],
            self::PASSWORD => ['required', 'string', AlphaNumSpaces::forPassword()],
        ];
    }

    public function toDto(): AuthLoginRequestDto
    {
        return new AuthLoginRequestDto(
            email: $this->string(self::EMAIL)->toString(),
            password: $this->string(self::PASSWORD)->toString(),
        );
    }
}
