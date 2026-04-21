<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProfileTableTest extends TestCase
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
     * Verify the structure of the "profiles" table.
     *
     * Purpose:
     * Ensures that the "profiles" table exists in the database
     * and contains all required columns.
     * 
     * @return void
     */
    public function test_profiles_table_exists_and_has_expected_columns(): void
    {
        // Assert that the "tasks" table exists
        $this->assertTrue(Schema::hasTable('profiles'));

        $this->assertTrue(Schema::hasColumn('profiles', 'user_id'));
        $this->assertTrue(Schema::hasColumn('profiles', 'phone'));
        $this->assertTrue(Schema::hasColumn('profiles', 'address'));
        $this->assertTrue(Schema::hasColumn('profiles', 'date_of_birth'));
        $this->assertTrue(Schema::hasColumn('profiles', 'bio'));
    }
}
