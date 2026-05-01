<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
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
     * Test if a user can successfully register with valid data.
     *
     * @return void 
     */
    public function test_user_can_register(): void
    {
        // Arrange: Prepare valid credentials for the registration process
        $credentials = [
            'name' => 'User Name',
            'email' => 'username@example.com',
            'password' => 'secretPassword',
            'password_confirmation' => 'secretPassword'
        ];

        // Act: Send a POST request to create a user
        $response = $this->post('/api/register', $credentials);

        // Assert: Check the resposnse status and content and datatbase content
        $response->assertStatus(201);
        $response->assertJsonFragment(['message' => 'User Created Successfully']);
        $user = User::where('email', 'username@example.com')->first();
        $this->assertDatabaseHas('users', [
            'id' => $user->id
        ]);
    }
}
