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

    public function test_authenticated_user_can_view_edit_page_for_owned_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create(['title' => 'Existing task']);

        $response = $this->actingAs($user)->get(route('tasks.edit', $task));

        $response->assertOk();
        $response->assertSee('Edit Task');
        $response->assertSee('Existing task');
    }

    public function test_user_cannot_view_edit_page_for_another_users_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.edit', $task));

        $response->assertForbidden();
    }

    public function test_authenticated_user_can_update_owned_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create([
            'title' => 'Old title',
            'description' => 'Old description',
            'status' => 'pending',
            'due_date' => '2026-04-25',
        ]);

        $response = $this->actingAs($user)->patch(route('tasks.update', $task), [
            'title' => 'Updated title',
            'description' => 'Updated description',
            'status' => 'completed',
            'due_date' => '2026-05-01',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('status', 'Task updated successfully.');

        $task->refresh();

        $this->assertSame('Updated title', $task->title);
        $this->assertSame('Updated description', $task->description);
        $this->assertSame('completed', $task->status);
        $this->assertSame('2026-05-01', $task->due_date?->format('Y-m-d'));
    }

    public function test_user_cannot_update_another_users_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['title' => 'Protected title']);

        $response = $this->actingAs($user)->patch(route('tasks.update', $task), [
            'title' => 'Hacked title',
            'description' => 'Should not update',
            'status' => 'completed',
            'due_date' => '2026-05-02',
        ]);

        $response->assertForbidden();

        $this->assertSame('Protected title', $task->fresh()->title);
    }
}
