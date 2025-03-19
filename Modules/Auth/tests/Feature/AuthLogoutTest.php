<?php

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);
uses()->group('auth', 'auth-logout');

describe('Auth Logout', function (): void {
    $endpoint = '/api/auth/logout';

    /*****************************************************************************************************************/
    /*                                              Success Tests                                                    */
    /*****************************************************************************************************************/

    test('should logout successfully', function () use ($endpoint): void {
        $loggedUsersCountBefore = PersonalAccessToken::query()->count();
        $user = UserFactory::new()->createOne();

        $token = $user->createToken('testToken')->plainTextToken;

        /** @var TestCase $this */
        $this
            ->withHeaders([
                'Authorization' => "Bearer $token"
            ])
            ->postJson($endpoint)
            ->assertNoContent();

        expect(
            PersonalAccessToken::query()->count()
        )->toEqual($loggedUsersCountBefore);
    });

    /*****************************************************************************************************************/
    /*                                                  Fail Tests                                                   */
    /*****************************************************************************************************************/

    test('should fail with 401 if not authenticated', function () use ($endpoint): void {
        /** @var TestCase $this */
        $this
            ->postJson($endpoint)
            ->assertUnauthorized()
            ->assertJson([
                'status' => -1,
                'message' => 'ERROR',
                'error' => 'You are not authenticated.'
            ]);
    });
});
