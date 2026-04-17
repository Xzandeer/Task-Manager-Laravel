<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold">Task List</h3>

                    @if ($tasks->isEmpty())
                        <p class="mt-4 text-sm text-gray-600">No tasks found.</p>
                    @else
                        <ul class="mt-4 space-y-3">
                            @foreach ($tasks as $task)
                                <li class="border rounded-lg p-4">
                                    <p class="font-medium">{{ $task->title }}</p>
                                    <p class="text-sm text-gray-600">{{ $task->status }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
