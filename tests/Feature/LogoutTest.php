<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test: Ensure that a user can successfully log out with the associated token.
     * 
     * @return void
     */
    public function test_user_can_logout(): void
    {
        // Arrange: Create a sample user and an associated token
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        // Act: Send a POST request with the Bearer token to logout
        $response = $this->postJson('/api/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Assert: Check the response status and content and database content
        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Logout Successful!']);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id
        ]);
    }
}
