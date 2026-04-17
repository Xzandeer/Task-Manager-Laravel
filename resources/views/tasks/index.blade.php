<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-slate-500">Overview</p>
                <h2 class="text-2xl font-semibold text-slate-900">
                    {{ __('Tasks') }}
                </h2>
            </div>
            <span class="rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-600">
                {{ $tasks->count() }} {{ \Illuminate\Support\Str::plural('task', $tasks->count()) }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="grid gap-4 md:grid-cols-3">
                <div class="tf-panel p-6">
                    <p class="text-sm font-medium text-slate-500">Pending</p>
                    <p class="mt-3 text-3xl font-semibold text-amber-500">{{ $tasks->where('status', 'pending')->count() }}</p>
                </div>
                <div class="tf-panel p-6">
                    <p class="text-sm font-medium text-slate-500">In Progress</p>
                    <p class="mt-3 text-3xl font-semibold text-sky-500">{{ $tasks->where('status', 'in_progress')->count() }}</p>
                </div>
                <div class="tf-panel p-6">
                    <p class="text-sm font-medium text-slate-500">Completed</p>
                    <p class="mt-3 text-3xl font-semibold text-emerald-500">{{ $tasks->where('status', 'completed')->count() }}</p>
                </div>
            </section>

            <section class="tf-panel overflow-hidden">
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Task List</h3>
                        <p class="text-sm text-slate-500">Manage your personal tasks here.</p>
                    </div>
                    <a href="{{ route('tasks.create') }}" class="tf-primary-btn">
                        Create Task
                    </a>
                </div>

                @if (session('status'))
                    <div class="border-b border-emerald-100 bg-emerald-50/90 px-6 py-3 text-sm font-medium text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($tasks->isEmpty())
                    <div class="px-6 py-12 text-center">
                        <p class="text-lg font-medium text-slate-700">No tasks found.</p>
                        <p class="mt-2 text-sm text-slate-500">Your tasks will appear here once you create them.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50/80">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Title</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Description</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Due Date</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach ($tasks as $task)
                                    <tr class="align-top transition hover:bg-slate-50/80">
                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">
                                            <a href="{{ route('tasks.show', $task) }}" class="transition hover:text-cyan-700">
                                                {{ $task->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600">
                                            {{ $task->description ?: 'No description provided.' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600">
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                                @class([
                                                    'bg-amber-100 text-amber-700' => $task->status === 'pending',
                                                    'bg-sky-100 text-sky-700' => $task->status === 'in_progress',
                                                    'bg-emerald-100 text-emerald-700' => $task->status === 'completed',
                                                ])">
                                                {{ str_replace('_', ' ', $task->status) }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                            {{ $task->due_date?->format('M d, Y') ?? 'No due date' }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                            <div class="flex items-center justify-end gap-4">
                                                <a href="{{ route('tasks.show', $task) }}" class="font-semibold text-cyan-700 transition hover:text-cyan-900">
                                                    View
                                                </a>
                                                <a href="{{ route('tasks.edit', $task) }}" class="font-semibold text-slate-700 transition hover:text-slate-900">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-semibold text-rose-600 transition hover:text-rose-800" onclick="return confirm('Delete this task?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>
