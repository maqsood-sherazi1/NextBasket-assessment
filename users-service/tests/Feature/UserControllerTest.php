<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * Insert user test.
     */
    public function test_user_can_be_created(): void
    {
        $response = $this->postJson('/api/users', [
            'email' => 'test@test.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'test@test.com']);
    }
}
