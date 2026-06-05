<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCrudTest extends TestCase
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
     * Test that a user can create a new task.
     */
    public function test_user_can_create_a_task(): void
    {
        // Arrange: Create a sample user and Prepare valid task data
        /** @var User $user */
        $user = User::factory()->create();
        $taskData = [
            'title' => 'Test Task',
            'description' => 'This is a test description',
            'priority' => 'high',
        ];

        // Act: Send a POST request to create a new task by an authenticated user
        $response = $this->actingAs($user)->post('/api/task', $taskData);

        // Assert: Check response status and content and database
        $response->assertStatus(201);
        $response->assertJsonFragment(['title' => 'Test Task']);
        $this->assertDatabaseHas('tasks', [
            'user_id' => $user->id,
            'title' => 'Test Task',
            'description' => 'This is a test description',
            'priority' => 'high',
        ]);
    }

    /**
     * Test that a user can view all stored tasks.
     */
    public function test_admin_can_show_all_tasks(): void
    {
        // Arrange: Create sample tasks
        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $tasks = Task::factory()->count(3)->create();

        // Act: Send GET request to fetch all tasks
        $response = $this->actingAs($admin)->get('/api/admin/tasks');

        // Assert: Check response status and content
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => $tasks[0]->title]);
        $response->assertJsonFragment(['description' => $tasks[1]->description]);
        $response->assertJsonFragment(['priority' => $tasks[2]->priority]);
    }

    /**
     * Test that a user can update a task by id.
     */
    public function test_user_can_update_a_task(): void
    {
        // Arrange: Create a sample user and an associated task
        /** @var User $user */
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'title' => 'Old Title',
            'description' => 'Old description',
            'priority' => 'high',
            'user_id' => $user->id,
        ]);

        // Create new data
        $updateData = [
            'title' => 'New Title',
            'description' => 'New description',
            'priority' => 'medium',
        ];

        // Act: Send a PUT request with new data by the authenticated user
        $response = $this->actingAs($user)->put("/api/task/{$task->id}", $updateData);

        // Assert: Check response status, content, and the task in database
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'New Title']);
        $this->assertDatabaseHas('tasks', [
            'user_id' => $user->id,
            'title' => 'New Title',
            'description' => 'New description',
            'priority' => 'medium',
        ]);
    }

    /**
     * Test that a user can view one task by id.
     */
    public function test_user_can_show_a_task(): void
    {
        // Arrange: Create a sample user and an associated task
        /** @var User $user */
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'title' => 'Sample Title',
            'description' => 'Sample description',
            'priority' => 'high',
            'user_id' => $user->id,
        ]);

        // Act: Send GET method to fetch a task by the authenticated user
        $response = $this->actingAs($user)->get("/api/task/{$task->id}");

        // Assert: Check response status and content
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => 'Sample Title',
            'description' => 'Sample description',
            'priority' => 'high',
        ]);
    }

    /**
     * Test that a user can delete a task by ID.
     */
    public function test_user_can_delete_a_task(): void
    {
        // Arrange: Create a sample user and an associated task
        /** @var User $user */
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        // Act: Send a DELETE request to delete a task by ID by the authenticated user
        $response = $this->actingAs($user)->delete("/api/task/{$task->id}");

        // Assert: Check response status and database content
        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
        $this->assertEmpty($response->getContent());
    }

    /**
     * Test the ability to view all user-associated tasks using the user ID.
     */
    public function test_user_can_view_all_associated_tasks(): void
    {
        // Arrange: Create a sample user and some associated tasks
        /** @var User $user */
        $user = User::factory()->create();
        $task1 = Task::create([
            'user_id' => $user->id,
            'title' => 'First Task',
            'description' => 'This description for the first task',
            'priority' => 'high',
        ]);
        $task2 = Task::create([
            'user_id' => $user->id,
            'title' => 'Second Task',
            'description' => 'This description for the second task',
            'priority' => 'medium',
        ]);
        $task3 = Task::create([
            'user_id' => $user->id,
            'title' => 'Third Task',
            'description' => 'This description for the third task',
            'priority' => 'low',
        ]);

        // Act: Send a GET request to fetch all the user-associated tasks by the authenticated user
        $response = $this->actingAs($user)->get('/api/tasks');

        // Assert: Check response status and content
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'First Task']);
        $response->assertJsonFragment(['title' => 'Second Task']);
        $response->assertJsonFragment(['title' => 'Third Task']);
    }

    /**
     * est the ability to display the task-associated user via the Task ID by the admin.
     */
    public function test_user_can_view_the_user_associated_with_task(): void
    {
        // Arrange: Create an admin, a user, and a user-associated task
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $task = Task::factory()->create(['user_id' => $user->id]);

        // Act: Send GET request to fetch the task-associated user
        $response = $this->actingAs($admin)->get("/api/task/{$task->id}/user");

        // Assert: Check response status and content
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $user->name]);
    }
}
