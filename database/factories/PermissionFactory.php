<?php

declare(strict_types=1);

namespace Database\Factories;

use BackedEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Permission;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'guard_name' => 'api',
        ];
    }

    public function withName(BackedEnum $permission): static
    {
        return $this->state(fn (array $attributes): array => [
            'name' => $permission->value
        ]);
    }
}
