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
    public function __construct(private readonly UserFactory $factory) {}

    public function run(): void
    {
        $this->truncateUsersTable();

        $this->command->info('Seeding users...');

        $this->seedUsers(2);
        $this->seedUnverifiedUsers(2);
        $this->seedSoftDeletedUsers(2);
        $this->seedUsersWithStatus(2, Statuses::ACTIVE);
        $this->seedUsersWithStatus(2, Statuses::INACTIVE);
        $this->seedUsersWithStatus(2, Statuses::PENDING);
        $this->seedUsersWithRole(1, Roles::SuperAdmin);

        $this->command->info('Users seeded successfully.');
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
        $this->factory
            ->count($quantity)
            ->create();
    }

    private function seedUnverifiedUsers(int $quantity): void
    {
        $this->factory
            ->count($quantity)
            ->unverified()
            ->create();
    }

    private function seedSoftDeletedUsers(int $quantity, ?Carbon $date = null): void
    {
        $this->factory
            ->count($quantity)
            ->softDeleted($date)
            ->create();
    }

    private function seedUsersWithStatus(int $quantity, ?Statuses $status = null): void
    {
        $this->factory
            ->count($quantity)
            ->withStatus($status)
            ->create();
    }

    private function seedUsersWithRole(int $quantity, Roles $role): void
    {
        $this->factory
            ->count($quantity)
            ->withRole($role)
            ->create();
    }
}
