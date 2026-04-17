<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->count(2)
            ->has(Task::factory()->count(10))
            ->create();
    }
}
