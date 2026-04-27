<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CategoriesTableTest extends TestCase
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
     * Verify the structure of the "categories" table.
     *
     * Purpose:
     * Ensures that the "categories" table exists in the database
     * and contains the required column for gategory management.
     * 
     * @return void
     */
    public function test_categories_table_exist_and_has_expected_column(): void
    {
        // Assert that the "categories" table exists
        $this->assertTrue(Schema::hasTable('categories'));

        // Assert that name column is present
        $this->assertTrue(Schema::hasColumn('categories', 'name'));
    }

    /**
     * Verify the structure of the "task_category" table.
     *
     * Purpose:
     * Ensures that the "task_catgory" table exists in the database
     * and contains the required ID columns for task-gategory management.
     * 
     * @return void
     */
    public function test_task_category_table_exist_and_has_expected_columns(): void
    {
        // Assert that the "categories" table exists
        $this->assertTrue(Schema::hasTable('task_category'));

        // Assert that ID columns are present
        $this->assertTrue(Schema::hasColumn('task_category', 'task_id'));
        $this->assertTrue(Schema::hasColumn('task_category', 'category_id'));
    }
}
