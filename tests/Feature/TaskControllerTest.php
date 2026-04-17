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

    public function test_create_task_page_requires_authentication(): void
    {
        $response = $this->get(route('tasks.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_a_task(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'Finish Laravel project',
            'description' => 'Complete create and store task feature.',
            'status' => 'pending',
            'due_date' => '2026-04-30',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('status', 'Task created successfully.');

        $this->assertDatabaseHas('tasks', [
            'user_id' => $user->id,
            'title' => 'Finish Laravel project',
            'description' => 'Complete create and store task feature.',
            'status' => 'pending',
        ]);

        $this->assertSame('2026-04-30', Task::firstOrFail()->due_date?->format('Y-m-d'));
    }
}
