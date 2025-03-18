<?php

declare(strict_types=1);

namespace Modules\Users\Http\Requests;

use App\Contracts\DataTransferableRequest;
use App\DataTransferObjects\PaginatorDto;
use App\Http\Requests\APIRequest;
use App\Rules\AlphaNumSpaces;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;
use Modules\Users\DataTransferObjects\UsersIndexRequestDto;
use Modules\Users\Enums\Statuses;
use Modules\Users\Models\User;

class UsersIndexRequest extends APIRequest implements DataTransferableRequest
{
    private const string STATUS = 'status';

    private const string FIRST_NAME = 'firstName';

    private const string LAST_NAME = 'lastName';

    private const string EMAIL = 'email';

    private const string PAGE = 'page';

    private const string PER_PAGE = 'perPage';

    public function authorize(): bool
    {
        Gate::authorize('index', User::class);
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->removeExactDuplicateInputs();
        $this->removeConflictingKeys($this->listFilterParametersKeys());
        $this->extractArrayNotationFor('filter');
        $this->removeConflictingKeys($this->listPaginateParametersKeys());
        $this->extractArrayNotationFor('paginate');
    }

    public function rules(): array
    {
        return [
            self::STATUS => ['nullable', new Enum(Statuses::class)],
            self::FIRST_NAME => ['nullable', 'string', AlphaNumSpaces::withoutNumbers()],
            self::LAST_NAME => ['nullable', 'string', AlphaNumSpaces::withoutNumbers()],
            self::EMAIL => ['nullable', 'string', AlphaNumSpaces::forEmail()],
            self::PAGE => ['nullable', 'integer', 'min:1'],
            self::PER_PAGE => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function toDto(): UsersIndexRequestDto
    {
        return new UsersIndexRequestDto(
            status: Statuses::tryFrom($this->string(self::STATUS)->toString()),
            firstName: $this->string(self::FIRST_NAME)->toString(),
            lastName: $this->string(self::LAST_NAME)->toString(),
            email: $this->string(self::EMAIL)->toString(),
            paginatorDto: new PaginatorDto(
                perPage: $this->integer('perPage'),
                page: $this->integer('page'),
            )
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

    private function listPaginateParametersKeys(): array
    {
        return [
            self::PAGE,
            self::PER_PAGE,
        ];
    }
}
