<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Roles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'guard_name' => 'api',
        ];
    }

    public function withName(Roles $role): static
    {
        return $this->state(fn (array $attributes): array => [
            'name' => $role->value
        ]);
    }
}
