<?php

use App\Enums\Permissions;
use App\Enums\Roles;
use App\Models\User;
use Database\Factories\PermissionFactory;
use Database\Factories\RoleFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Users\Enums\Statuses;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);
uses()->group('users', 'users-index');

beforeEach(function (): void {
    Permission::query()->delete();
    Role::query()->delete();
    $user = UserFactory::new()->createOne();
    /** @var Role $superAdminRole */
    $superAdminRole = RoleFactory::new()->withName(Roles::SuperAdmin)->createOne();
    $user->assignRole($superAdminRole);
    /** @var Permission $userListPermission */
    $userListPermission = PermissionFactory::new()->withName(Permissions::UsersList)->createOne();
    $superAdminRole->givePermissionTo($userListPermission);
    /** @var TestCase $this */
    $this->actingAs($user);
});

describe('Users Index', function (): void {
    $endpoint = '/api/users';

    /*****************************************************************************************************************/
    /*                                              Success Tests                                                    */
    /*****************************************************************************************************************/

    test('should return a list of users', function () use ($endpoint): void {
        $user = UserFactory::new()->createOne();

        $expectedUserAttributes = $user->makeHidden($user->getHidden())->toArray();
        $expectedUserCamelKeys = collect($expectedUserAttributes)
            ->mapWithKeys(
                fn (mixed $value, string $key): array => [Str::camel($key) => $value]
            )
            ->keys()
            ->toArray();

        /** @var TestCase $this */
        $this->get($endpoint)
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'data' => [
                        '*' => $expectedUserCamelKeys,
                    ],
                    'meta' => [
                        'current_page',
                        'from',
                        'per_page',
                        'to',
                    ],
                    'links' => [
                        'first',
                        'prev',
                        'next',
                    ],
                ],
            ]);
    });

    test('should not filter if no filter is sent', function () use ($endpoint): void {
        $usersQuantity = 5;
        $existingUsers = User::query()->pluck('id')->toArray();
        UserFactory::new()->count($usersQuantity)->create();
        User::query()->whereIn('id', $existingUsers)->forceDelete();

        /** @var TestCase $this */
        $this->get($endpoint)
            ->assertOk()
            ->assertJsonCount(
                count: $usersQuantity,
                key: 'data.data'
            );
    });

    test('should not filter if filters are not in array notation', function () use ($endpoint): void {
        $usersQuantity = 5;
        $existingUsers = User::query()->pluck('id')->toArray();
        /** @var Collection<int, User> $createdUsers */
        $createdUsers = UserFactory::new()->count($usersQuantity)->create();
        User::query()->whereIn('id', $existingUsers)->forceDelete();

        /** @var TestCase $this */
        $this->get($endpoint . '?email=' . $createdUsers->firstOrFail()->email)
            ->assertOk()
            ->assertJsonCount(
                count: $usersQuantity,
                key: 'data.data'
            );
    });

    test('should filter if filters are in array notation', function () use ($endpoint): void {
        $existingUsers = User::query()->pluck('id')->toArray();
        /** @var Collection<int, User> $createdUsers */
        $createdUsers = UserFactory::new()->count(5)->create();
        User::query()->whereIn('id', $existingUsers)->forceDelete();

        /** @var TestCase $this */
        $this->get($endpoint . '?filter[email]=' . $createdUsers->firstOrFail()->email)
            ->assertOk()
            ->assertJsonCount(
                count: 1,
                key: 'data.data'
            );
    });

    test('should work with two or more filters together', function () use ($endpoint): void {
        $status = Statuses::ACTIVE;
        $existingUsers = User::query()->pluck('id')->toArray();
        /** @var Collection<int, User> $createdUsers */
        $createdUsers = UserFactory::new()->withStatus($status)->count(5)->create();
        User::query()->whereIn('id', $existingUsers)->forceDelete();

        $userToFilter = $createdUsers->firstOrFail();
        $email = $userToFilter->email;

        /** @var TestCase $this */
        $this->get($endpoint . "?filter[email]={$email}&filter[status]={$status->value}")
            ->assertOk()
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.email', $email)
            ->assertJsonPath('data.data.0.status', $status->value);
    });

    test('should bring results by the perPage received by parameter', function () use ($endpoint): void {
        $existingUsers = User::query()->pluck('id')->toArray();
        UserFactory::new()->count(5)->create();
        User::query()->whereIn('id', $existingUsers)->forceDelete();

        $perPage = 2;

        /** @var TestCase $this */
        $this->get($endpoint . "?paginate[perPage]={$perPage}")
            ->assertOk()
            ->assertJsonCount(
                count: $perPage,
                key: 'data.data'
            );
    });

    test('should bring results by page received by parameter', function () use ($endpoint): void {
        $existingUsers = User::query()->pluck('id')->toArray();
        UserFactory::new()->createOne();
        User::query()->whereIn('id', $existingUsers)->forceDelete();

        /** @var TestCase $this */
        $this->get($endpoint . "?paginate[page]=2")
            ->assertOk()
            ->assertJsonCount(
                count: 0,
                key: 'data.data'
            );
    });

    /*****************************************************************************************************************/
    /*                                                  Fail Tests                                                   */
    /*****************************************************************************************************************/

    test('should fail with 422 if invalid first name is send', function () use ($endpoint): void {
        /** @var TestCase $this */
        $this->get($endpoint . '?filter[firstName]=12345')
            ->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'status' => -1,
                'message' => 'ERROR',
                'error' => [
                    "firstName" => [
                        "The first name can not contain numbers."
                    ]
                ],
            ]);
    });

    test('should fail with 422 if invalid last name is send', function () use ($endpoint): void {
        /** @var TestCase $this */
        $this->get($endpoint . '?filter[lastName]=12345')
            ->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'status' => -1,
                'message' => 'ERROR',
                'error' => [
                    "lastName" => [
                        "The last name can not contain numbers."
                    ]
                ],
            ]);
    });

    test('should fail with 422 if invalid email is send', function () use ($endpoint): void {
        /** @var TestCase $this */
        $this->get($endpoint . '?filter[email]=|')
            ->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'status' => -1,
                'message' => 'ERROR',
                'error' => [
                    "email" => [
                        "The email can not contain special characters."
                    ]
                ],
            ]);
    });
});

