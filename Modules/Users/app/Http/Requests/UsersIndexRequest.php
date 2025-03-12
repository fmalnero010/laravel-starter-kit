<?php

declare(strict_types=1);

namespace Modules\Users\Http\Requests;

use App\Contracts\DataTransferableRequest;
use App\Rules\AlphaNumSpaces;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Modules\Users\DataTransferObjects\UsersIndexRequestDto;
use Modules\Users\Enums\Statuses;

class UsersIndexRequest extends FormRequest implements DataTransferableRequest
{
    private const string STATUS     = 'status';
    private const string FIRST_NAME = 'firstName';
    private const string LAST_NAME  = 'lastName';
    private const string EMAIL      = 'email';

    public function rules(): array
    {
        return [
            self::STATUS     => ['nullable', new Enum(Statuses::class)],
            self::FIRST_NAME => ['nullable', 'string', new AlphaNumSpaces],
            self::LAST_NAME  => ['nullable', 'string', new AlphaNumSpaces],
            self::EMAIL      => ['nullable', 'string', new AlphaNumSpaces],
        ];
    }

    public function toDto(): UsersIndexRequestDto
    {
        return new UsersIndexRequestDto(
            status:    Statuses::tryFrom($this->string(self::STATUS)->toString()),
            firstName: $this->string(self::FIRST_NAME)->toString(),
            lastName:  $this->string(self::LAST_NAME)->toString(),
            email:     $this->string(self::EMAIL)->toString(),
        );
    }
}
