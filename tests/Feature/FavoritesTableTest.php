<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FavoritesTableTest extends TestCase
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
     * Verify the structure of the "favorites" table.
     *
     * Purpose:
     * Ensures that the "favorites" table exists in the database
     * and contains the required ID columns for favorite management.
     */
    public function test_task_category_table_exist_and_has_expected_columns(): void
    {
        // Assert that the "favorites" table exists
        $this->assertTrue(Schema::hasTable('favorites'));

        // Assert that ID columns are present
        $this->assertTrue(Schema::hasColumn('favorites', 'user_id'));
        $this->assertTrue(Schema::hasColumn('favorites', 'task_id'));
    }
}
