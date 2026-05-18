<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileRelationshipTest extends TestCase
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
     * Test that a user can create the associated profile.
     */
    public function test_user_can_create_a_profile(): void
    {
        // Arrange: Create a user and a profile in data base
        /** @var User $user */
        $user = User::factory()->create();

        $profileData = [
            'user_id' => $user->id,
            'phone' => '123456789',
            'address' => 'Test address',
            'date_of_birth' => '2026-04-23',
            'bio' => 'Software Engineer.',
        ];

        // Act: Send a POST request to create a profile by the authenticated user
        $response = $this->actingAs($user)->post('/api/profile', $profileData);

        // Assert: Check response status and content
        $response->assertStatus(201);
        $response->assertJsonFragment(['user_id' => $user->id]);
        $response->assertJsonFragment(['phone' => '123456789']);
        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'phone' => '123456789',
        ]);
    }

    /**
     * Test that a user can view the associated profile.
     */
    public function test_user_can_view_associated_profile(): void
    {
        // Arrange: Create a user in database
        $user = User::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'phone' => '123456789',
        ]);

        // Act: Send Get request to fetch the user's associated profile
        $response = $this->get("/api/profile/{$user->id}");

        // Assert: Check the response status and content
        $response->assertStatus(200);
        $response->assertJsonFragment(['phone' => $profile->phone]);
    }

    /**
     * Test that a user can update the associated profile by user ID.
     */
    public function test_user_can_update_associated_profile(): void
    {
        // Arrange: Create a sample user, an associated profile, and new profile data
        $user = User::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'phone' => '123456789',
            'address' => 'Test address',
            'date_of_birth' => '2026-04-23',
            'bio' => 'Software Engineer.',
        ]);
        $updateDate = [
            'phone' => '0123456789',
            'address' => 'New address',
            'date_of_birth' => '2025-04-24',
            'bio' => 'Back-End Developer.',
        ];

        // Act: Send PUT request with new data
        $response = $this->put("/api/profile/{$user->id}", $updateDate);

        // Assert: Check response status, content, and the profile in database
        $response->assertStatus(200);
        $response->assertJsonFragment(['phone' => '0123456789']);
        $this->assertDatabaseHas('profiles', $updateDate);
    }
}
