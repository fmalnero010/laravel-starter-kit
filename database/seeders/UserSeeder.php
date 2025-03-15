<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Modules\Users\Enums\Statuses;

class UserSeeder extends Seeder
{
    public function __construct(private readonly UserFactory $factory)
    {
    }

    public function run(): void
    {
        $this->truncateUsersTable();

        $this->seedUsers(2);
        $this->seedUnverifiedUsers(2);
        $this->seedSoftDeletedUsers(2);
        $this->seedUsersWithStatus(2, Statuses::ACTIVE);
        $this->seedUsersWithStatus(2, Statuses::INACTIVE);
        $this->seedUsersWithStatus(2, Statuses::PENDING);
        $this->seedUsersWithRole(1, Roles::SuperAdmin);
    }

    private function truncateUsersTable(): void
    {
        $this->command->info('Truncating users table...');

        User::query()
            ->truncate();

        $this->command->info("User's table truncated successfully.");
    }

    private function seedUsers(int $quantity): void
    {
        $this->command->info('Seeding users...');

        $this->factory
            ->count($quantity)
            ->create();

        $this->command->info('Users seeded successfully.');
    }

    private function seedUnverifiedUsers(int $quantity): void
    {
        $this->command->info('Seeding unverified users...');

        $this->factory
            ->count($quantity)
            ->unverified()
            ->create();

        $this->command->info('Unverified users seeded successfully.');
    }

    private function seedSoftDeletedUsers(int $quantity, Carbon|null $date = null): void
    {
        $this->command->info('Seeding soft deleted users...');

        $this->factory
            ->count($quantity)
            ->softDeleted($date)
            ->create();

        $this->command->info('Soft deleted users seeded successfully.');
    }

    private function seedUsersWithStatus(int $quantity, Statuses|null $status = null): void
    {
        $this->command->info("Seeding users with status: {$status->value}...");

        $this->factory
            ->count($quantity)
            ->withStatus($status)
            ->create();

        $this->command->info("Users with status {$status->value} seeded successfully.");
    }

    private function seedUsersWithRole(int $quantity, Roles $role): void
    {
        $this->command->info("Seeding users with role: {$role->value}...");

        $this->factory
            ->count($quantity)
            ->withRole($role)
            ->create();

        $this->command->info("Users with role {$role->value} seeded successfully.");
    }
}
