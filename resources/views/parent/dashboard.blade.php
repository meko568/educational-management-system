<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Parent Dashboard') }}
            </h2>
            <form method="POST" action="{{ route('parent.logout') }}">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                    Logout
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Parent Code: <span class="font-semibold">{{ $parent->code }}</span></p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Phone: <span class="font-semibold">{{ $parent->phone_number }}</span></p>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Sons</h3>

                    @if($sons->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">No sons linked to this parent yet.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($sons as $son)
                                <a href="{{ route('parent.sons.show', $son) }}" class="block border border-gray-200 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 hover:shadow">
                                    <div class="text-sm text-gray-600 dark:text-gray-300">Student Code: <span class="font-semibold">{{ $son->code }}</span></div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $son->name }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">Academic Year: <span class="font-semibold">{{ $son->academicYear }}</span></div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
