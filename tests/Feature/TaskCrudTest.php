<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
     * 
     * @return void
     */
    public function test_user_can_create_a_task(): void
    {
        // Arrange: Prepare valid task data
        $taskData =  [
            'title' => 'Test Task',
            'description' => 'This is a test description',
            'priority' => 1,
        ];

        // Act: Send POST request to create a new task
        $response = $this->post('/api/task', $taskData);

        // Assert: Check response status and content
        $response->assertStatus(201);
        $response->assertJsonFragment(['title' => 'Test Task']);
        $this->assertDatabaseHas('tasks', $taskData);
    }

    /**
     * Test that a user can view all stored tasks.
     * 
     * @return void
     */
    public function test_user_can_show_all_tasks(): void
    {
        // Arrange: Create sample tasks
        $tasks = \App\Models\Task::factory()->count(3)->create();

        // Act: Send GET request to fetch all tasks
        $response = $this->get('/api/tasks');

        // Assert: Check response status and content
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => $tasks[0]->title]);
        $response->assertJsonFragment(['description' => $tasks[1]->description]);
        $response->assertJsonFragment(['priority' => $tasks[2]->priority]);
    }

    /**
     * Test that a user can update a task by id.
     * 
     * @return void
     */
    public function test_user_can_update_a_task(): void
    {
        // Arrange: Create a sample task
        $task = Task::factory()->create([
            'title' => 'Old Title',
            'description' => 'Old description',
            'priority' => 1,
        ]);

        // Create new data
        $updateData = [
            'title' => 'New Title',
            'description' => 'New description',
            'priority' => 2,
        ];

        // Act: Send PUT request with new data
        $response = $this->put("/api/task/{$task->id}", $updateData);

        // Assert: Check response status, content, and the task in database
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'New Title']);
        $this->assertDatabaseHas('tasks', $updateData);
    }


    /**
     * Test that a user can view one task by id.
     */
    public function test_user_can_show_a_task(): void
    {
        // Arrange: Create a sample task
        $task = Task::factory()->create([
            'title' => 'Sample Title',
            'description' => 'Sample description',
            'priority' => 1,
        ]);

        // Act: Send GET method to fitch a task
        $response = $this->get("/api/task/{$task->id}");

        // Assert: Check response status and content
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => 'Sample Title',
            'description' => 'Sample description',
            'priority' => 1,
        ]);
    }
}
