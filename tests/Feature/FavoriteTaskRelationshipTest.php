<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTaskRelationshipTest extends TestCase
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
     * Test that a user can add a task to their favorites.
     * Ensures the favorites table contains the correct record.
     */
    public function test_user_can_add_a_task_to_favorite(): void
    {
        // Arrange: Create a sample user and a task
        /** @var User $user */
        $user = User::factory()->create();
        $task = Task::factory()->create();

        // Act: Send a POST request to add a task to favorites
        $response = $this->actingAs($user)->post("/api/tasks/{$task->id}/favorite");

        // Asssert: Check the response status and the content
        $response->assertStatus(200);
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);
    }

    /**
     * Test that a user can remove a task from their favorites.
     * Ensures that the deleted task does not exist in the favorites.
     */
    public function test_user_can_remove_a_task_from_favorites(): void
    {
        // Arrange: Create a sample user and a task in favorites
        /** @var User $user */
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $user->favoriteTasks()->syncWithoutDetaching($task->id);

        // Act: Send a DELETE request to remove the task from favorites
        $response = $this->actingAs($user)->delete("/api/tasks/{$task->id}/favorite");

        // Assert: Check the response status and content
        $response->assertStatus(200);
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);
    }
}
