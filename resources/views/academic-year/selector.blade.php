<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Select Academic Year') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    {{ __('Welcome') }}, {{ auth()->user()->name }}!
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('Select an academic year to view its dashboard') }}
                </p>
            </div>

            @if($academicYears->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($yearStats as $stat)
                <a href="{{ route('academic-year.select', ['academicYear' => $stat['academicYear']]) }}"
                   class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                    {{ __('Academic Year') }}: {{ $stat['academicYear'] }}
                                </h3>
                            </div>
                            <div class="text-indigo-500 dark:text-indigo-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Students Card -->
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-4 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-blue-100 text-sm font-medium">{{ __('Students') }}</p>
                                        <p class="text-2xl font-bold">{{ $stat['students'] }}</p>
                                    </div>
                                    <svg class="w-10 h-10 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 12a6 6 0 11-12 0 6 6 0 0112 0z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Exams Card -->
                            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-4 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-green-100 text-sm font-medium">{{ __('Exams') }}</p>
                                        <p class="text-2xl font-bold">{{ $stat['exams'] }}</p>
                                    </div>
                                    <svg class="w-10 h-10 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Quizzes Card -->
                            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg p-4 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-yellow-100 text-sm font-medium">{{ __('Quizzes') }}</p>
                                        <p class="text-2xl font-bold">{{ $stat['quizzes'] }}</p>
                                    </div>
                                    <svg class="w-10 h-10 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Attendance Card -->
                            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg p-4 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-red-100 text-sm font-medium">{{ __('Attendance') }}</p>
                                        <p class="text-2xl font-bold">{{ $stat['attendance'] }}</p>
                                    </div>
                                    <svg class="w-10 h-10 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-600 dark:text-gray-400 text-center py-8">
                    {{ __('No academic years available yet.') }}
                </p>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
