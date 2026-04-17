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
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <p class="text-sm font-medium text-slate-500">Pending</p>
                    <p class="mt-3 text-3xl font-semibold text-amber-500">{{ $tasks->where('status', 'pending')->count() }}</p>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <p class="text-sm font-medium text-slate-500">In Progress</p>
                    <p class="mt-3 text-3xl font-semibold text-sky-500">{{ $tasks->where('status', 'in_progress')->count() }}</p>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <p class="text-sm font-medium text-slate-500">Completed</p>
                    <p class="mt-3 text-3xl font-semibold text-emerald-500">{{ $tasks->where('status', 'completed')->count() }}</p>
                </div>
            </section>

            <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Task List</h3>
                        <p class="text-sm text-slate-500">Manage your personal tasks here.</p>
                    </div>
                </div>

                @if ($tasks->isEmpty())
                    <div class="px-6 py-12 text-center">
                        <p class="text-lg font-medium text-slate-700">No tasks found.</p>
                        <p class="mt-2 text-sm text-slate-500">Your tasks will appear here once you create them.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Title</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Description</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Due Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach ($tasks as $task)
                                    <tr class="align-top">
                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">
                                            {{ $task->title }}
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
