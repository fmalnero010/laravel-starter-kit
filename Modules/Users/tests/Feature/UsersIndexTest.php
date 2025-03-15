<?php

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

uses(
    TestCase::class,
    DatabaseTransactions::class
);

describe('Users Index', function () {
    $endpoint = '/api/users';

    it('should return a list of users', function () use ($endpoint): void {
        $user = UserFactory::new()->createOne();

        $expectedUserAttributes = $user->makeHidden(
            $user->getHidden()
        )->toArray();

        $expectedUserCamelKeys = collect($expectedUserAttributes)
            ->mapWithKeys(
                fn ($value, $key): array => [Str::camel($key) => $value]
            )
            ->keys()
            ->toArray();

        $this
            ->getJson($endpoint)
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'data' => [
                        '*' => $expectedUserCamelKeys
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
                    ]
                ]
            ]);
    });
});
