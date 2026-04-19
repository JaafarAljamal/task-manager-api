<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TasksTableTest extends TestCase
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
     * Verify the structure of the "tasks" table.
     *
     * Purpose:
     * Ensures that the "tasks" table exists in the database
     * and contains all required columns for task management.
     * 
     * @return void
     */
    public function test_tasks_table_exists_and_has_expected_columns(): void
    {
        // Assert that the "tasks" table exists
        $this->assertTrue(Schema::hasTable('tasks'));

        // Assert that essential columns are present
        $this->assertTrue(Schema::hasColumn('tasks', 'id'));
        $this->assertTrue(Schema::hasColumn('tasks', 'title'));
        $this->assertTrue(Schema::hasColumn('tasks', 'description'));
        $this->assertTrue(Schema::hasColumn('tasks', 'priority'));
        $this->assertTrue(Schema::hasColumn('tasks', 'created_at'));
        $this->assertTrue(Schema::hasColumn('tasks', 'updated_at'));
    }
}
