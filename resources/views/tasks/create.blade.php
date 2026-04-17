<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium uppercase tracking-[0.2em] text-slate-500">New Task</p>
            <h2 class="text-2xl font-semibold text-slate-900">Create Task</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <section class="tf-panel p-6">
                <div class="mb-6 rounded-2xl bg-cyan-50 px-5 py-4 text-sm text-cyan-900 ring-1 ring-cyan-100">
                    Add the core details first. You can keep the description or due date empty if you want a faster entry.
                </div>

                <form method="POST" action="{{ route('tasks.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" class="tf-input" :value="old('title')" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="4" class="tf-textarea">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="tf-select" required>
                                @foreach (['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status', 'pending') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="due_date" :value="__('Due Date')" />
                            <x-text-input id="due_date" name="due_date" type="date" class="tf-input" :value="old('due_date')" />
                            <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('tasks.index') }}" class="tf-secondary-btn">
                            Cancel
                        </a>
                        <button type="submit" class="tf-primary-btn">
                            Save Task
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
