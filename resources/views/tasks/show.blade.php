<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-slate-500">Task Details</p>
                <h2 class="text-2xl font-semibold text-slate-900">{{ $task->title }}</h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('tasks.edit', $task) }}" class="tf-secondary-btn">Edit Task</a>
                <a href="{{ route('tasks.index') }}" class="tf-primary-btn">Back to Tasks</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="grid gap-4 md:grid-cols-3">
                <div class="tf-panel p-6">
                    <p class="text-sm font-medium text-slate-500">Status</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900">{{ str_replace('_', ' ', $task->status) }}</p>
                </div>
                <div class="tf-panel p-6">
                    <p class="text-sm font-medium text-slate-500">Due Date</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900">{{ $task->due_date?->format('M d, Y') ?? 'No due date' }}</p>
                </div>
                <div class="tf-panel p-6">
                    <p class="text-sm font-medium text-slate-500">Created</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900">{{ $task->created_at->format('M d, Y') }}</p>
                </div>
            </section>

            <section class="tf-panel p-6">
                <h3 class="text-lg font-semibold text-slate-900">Description</h3>
                <div class="mt-4 rounded-2xl bg-slate-50 px-5 py-4 text-sm leading-7 text-slate-600">
                    {{ $task->description ?: 'No description provided for this task.' }}
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
