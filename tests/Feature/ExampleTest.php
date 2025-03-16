<?php

use Tests\TestCase;

class ExampleFeatureTest extends TestCase
{
    public function test_homepage_returns_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
