<?php

declare(strict_types=1);

namespace Modules\Users\Http\Requests;

use App\Contracts\DataTransferableRequest;
use App\Http\Requests\APIRequest;
use App\Rules\AlphaNumSpaces;
use Illuminate\Validation\Rules\Enum;
use Modules\Users\DataTransferObjects\UsersIndexRequestDto;
use Modules\Users\Enums\Statuses;

class UsersIndexRequest extends APIRequest implements DataTransferableRequest
{
    private const string STATUS     = 'status';
    private const string FIRST_NAME = 'firstName';
    private const string LAST_NAME  = 'lastName';
    private const string EMAIL      = 'email';

    protected function prepareForValidation(): void
    {
        $this->removeExactDuplicateInputs();
        $this->removeConflictingKeys($this->listFilterParametersKeys());
        $this->extractDotNotationFor('filter');
    }

    public function rules(): array
    {
        return [
            self::STATUS     => ['nullable', new Enum(Statuses::class)],
            self::FIRST_NAME => ['nullable', 'string', new AlphaNumSpaces],
            self::LAST_NAME  => ['nullable', 'string', new AlphaNumSpaces],
            self::EMAIL      => ['nullable', 'string', AlphaNumSpaces::withAllowedCharacters('@.-_')],
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

    private function listFilterParametersKeys(): array
    {
        return [
            self::STATUS,
            self::FIRST_NAME,
            self::LAST_NAME,
            self::EMAIL,
        ];
    }
}
