<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCategoryRelationshipTest extends TestCase
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
     * Test that a user can attach a category to a task by task ID.
     * 
     * @return void
     */
    public function test_user_can_add_categories_to_a_task(): void
    {
        // Arrange: Create a user-associated task and a category 
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $category = Category::create(['name' => 'Category 1']);

        // Act: Send a POST request to attach the category to the task
        $response = $this->post("/api/task/{$task->id}/categories", [
            'category_id' => $category->id
        ]);

        // Assert: Check response status and content and database content
        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Category attached successfully']);
        $this->assertDatabaseHas('task_category', [
            'task_id' => $task->id,
            'category_id' => $category->id
        ]);
    }

    /**
     * Test that the user can display the attached categories to the given task by the task ID.
     * 
     * @return void
     */
    public function test_user_can_view_the_attached_categories_of_a_task(): void
    {
        // Arrange: Create a category-attached task
        $task = Task::factory()->create();
        $category = Category::create(['name' => 'Category_1']);
        $task->categories()->attach($category->id);

        // Act: Send a GET request to fetch the categories attached to the task by its ID
        $response = $this->get("/api/task/{$task->id}/categories");

        // Assert: Check response status and content
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Category_1']);
    }
}
