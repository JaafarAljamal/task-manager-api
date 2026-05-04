<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
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
     * Test: Ensure that a user can successfully log in with valid credentials.
     * 
     * @return void
     */
    public function test_user_can_login_with_correct_credentials(): void
    {
        // Arrange: Prepare a user, valid credentials for login process
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password1234')
        ]);
        $credentials = [
            'email' => 'test@example.com',
            'password' => 'password1234'
        ];

        // Act: Send a POST request to attempt to login
        $response = $this->post('/api/login', $credentials);

        // Assert: Check response status and content
        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('token'));
        $this->assertEquals('Bearer', $response->json('token_type'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test: Ensure that a user cannot log in with an incorrect password.
     * 
     * @return void
     */
    public function test_user_cannot_login_with_incorrect_credentials(): void
    {
        // Arrange: Create a valid user and incorrect login credentials
        $user = User::create([
            'name' => 'WrongPassUser',
            'email' => 'wrong@example.com',
            'password' => bcrypt('correct123')
        ]);

        $incorrectCredintials = [
            'email' => 'wrong@example.com',
            'password' => 'wrongPassword'
        ];

        // Act:  Send a POST request to attempt to login
        $response = $this->post('/api/login', $incorrectCredintials);

        // Assert: Check response status and content
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Invalid Email or Password!']);
        $this->assertGuest();
    }
}
