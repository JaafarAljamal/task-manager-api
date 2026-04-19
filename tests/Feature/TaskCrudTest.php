<?php

namespace Tests\Feature;

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
}
