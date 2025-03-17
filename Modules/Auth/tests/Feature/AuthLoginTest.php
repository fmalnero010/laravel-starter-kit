<?php

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);
uses()->group('auth', 'auth-login');

describe('Auth Login', function (): void {
    $endpoint = '/api/auth/login';

    /*****************************************************************************************************************/
    /*                                              Success Tests                                                    */
    /*****************************************************************************************************************/

    test('should login successfully', function () use ($endpoint): void {
        User::query()->forceDelete();
        PersonalAccessToken::query()->forceDelete();

        $user = UserFactory::new()->createOne();

        /** @var TestCase $this */
        $response = $this->postJson(
            $endpoint,
            [
                'email' => $user->email,
                'password' => UserFactory::$password,
            ]
        );

        $response
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'accessToken',
                    'tokenType',
                    'expiresAt',
                    'user' => [
                        'id',
                        'status',
                        'firstName',
                        'lastName',
                        'email',
                    ],
                ]
            ]);

        expect(
            PersonalAccessToken::query()
                ->where('tokenable_id', $user->id)
                ->where('expires_at', $response->json('expires_at'))
                ->exists()
        )->toBeTrue();
    });

    test('should eliminate all other user tokens when logging in', function () use ($endpoint): void {
        User::query()->forceDelete();
        PersonalAccessToken::query()->forceDelete();

        $user = UserFactory::new()->createOne();
        Auth::login($user);

        /** @var TestCase $this */
        $response = $this->postJson(
            $endpoint,
            [
                'email' => $user->email,
                'password' => UserFactory::$password,
            ]
        );

        expect(
            PersonalAccessToken::query()
                ->where('tokenable_id', $user->id)
                ->where('expires_at', $response->json('expires_at'))
                ->exists()
        )->toBeTrue();
    });

    /*****************************************************************************************************************/
    /*                                                  Fail Tests                                                   */
    /*****************************************************************************************************************/

    test('should fail with 401 if email or password is incorrect', function () use ($endpoint): void {
        User::query()->forceDelete();

        $user = UserFactory::new()->createOne();

        /** @var TestCase $this */
        $response = $this->postJson(
            $endpoint,
            [
                'email' => $user->email,
                'password' => UserFactory::$password . '-',
            ]
        );

        $response
            ->assertUnauthorized()
            ->assertJson([
                'status' => -1,
                'message' => 'ERROR',
                'error' => 'The given credentials are invalid'
            ]);
    });

    test('should fail with 422 if email or password have an incorrect type', function () use ($endpoint): void {
        /** @var TestCase $this */
        $response = $this->postJson(
            $endpoint,
            [
                'email' => 'hey123',
                'password' => 'hey123',
            ]
        );

        $response
            ->assertUnprocessable()
            ->assertJson([
                'status' => -1,
                'message' => 'ERROR',
                'error' => [
                    'email' => ['The email field must be a valid email address.'],
                    'password' => [
                        'The password field must be at least 8 characters.',
                        'The password field must contain at least one uppercase and one lowercase letter.',
                        'The password field must contain at least one symbol.'
                    ]
                ]
            ]);
    });
});
