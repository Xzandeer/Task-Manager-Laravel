<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_index_requires_authentication(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_tasks_index_only_shows_authenticated_users_tasks(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $userTask = Task::factory()->for($user)->create(['title' => 'My task']);
        $otherTask = Task::factory()->for($otherUser)->create(['title' => 'Other task']);

        $response = $this->actingAs($user)->get(route('tasks.index'));

        $response->assertOk();
        $response->assertSee($userTask->title);
        $response->assertDontSee($otherTask->title);
    }
}
