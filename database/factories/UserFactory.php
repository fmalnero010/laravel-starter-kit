<?php

namespace Database\Factories;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Modules\Users\Enums\Statuses;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password = 'Password1!';

    protected $model = User::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => Statuses::ACTIVE,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes): array => [
            'email_verified_at' => null,
        ]);
    }

    public function withStatus(?Statuses $status = null): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => $status ?? Statuses::ACTIVE,
        ]);
    }

    public function softDeleted(?Carbon $date = null): static
    {
        return $this->state(fn (array $attributes): array => [
            'deleted_at' => $date ?? now(),
        ]);
    }

    public function withRole(Roles $role): static
    {
        return $this->afterCreating(function (User $user) use ($role): void {
            $roleModel = Role::query()
                ->where('name', $role->value)
                ->firstOrFail();

            $user->assignRole($roleModel);
        });
    }
}
