<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTwoFactorTest extends TestCase
{
    use RefreshDatabase;

    public function testTwoFactorEmail(): void
    {
        // status and content
        // Passport::actingAsClient(
        //     \factory(Client::class)->create(),
        //     ['auth-manage'],
        // );

        // $response = $this->postJson('/register', [
        //     'email' => $this->faker->safeEmail,
        //     'password' => Str::random(16),
        // ]);

        // $response->assertStatus(422);
    }

    public function testGoogleTwoFactor(): void
    {
        // status and content
        // Passport::actingAsClient(
        //     \factory(Client::class)->create(),
        //     ['auth-manage'],
        // );

        // $response = $this->postJson('/register', [
        //     'name' => $this->faker->name,
        //     'email' => $this->faker->safeEmail,
        //     'password' => Str::random(16),
        // ]);

        // $response->assertStatus(201);
    }
}
