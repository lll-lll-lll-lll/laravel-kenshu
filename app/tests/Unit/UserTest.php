<?php

namespace Tests\Unit;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    public function test_count_users(): void
    {
        $this->seed([DatabaseSeeder::class]);
        $this->assertDatabaseCount('users', 3);
    }
}
