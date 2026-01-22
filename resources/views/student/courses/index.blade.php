<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Available Courses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <!-- Subscription Status -->
                    <div class="mb-6 p-4 rounded-lg @if($student->hasValidSubscription()) bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 @else bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 @endif">
                        <div class="flex items-start">
                            <div class="flex-1">
                                @if($student->hasValidSubscription())
                                    <h3 class="text-lg font-semibold text-green-800 dark:text-green-200">✓ Active Subscription</h3>
                                    <p class="text-sm text-green-700 dark:text-green-300 mt-1">
                                        Your subscription is valid until: <span class="font-semibold">{{ $student->getSubscriptionExpiryDate()->format('F d, Y') }}</span>
                                    </p>
                                    <p class="text-xs text-green-600 dark:text-green-400 mt-2">You have full access to all course content</p>
                                @else
                                    <h3 class="text-lg font-semibold text-red-800 dark:text-red-200">✗ No Active Subscription</h3>
                                    <p class="text-sm text-red-700 dark:text-red-300 mt-1">Your subscription has expired or you haven't made a payment yet.</p>
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-2">Please contact your instructor or check your account payment status.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($courses->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">No courses available yet.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($courses as $course)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 border border-gray-200 dark:border-gray-600 hover:shadow-lg transition">
                                    <div class="mb-4">
                                        <span class="inline-block px-2 py-1 text-xs font-semibold text-blue-700 dark:text-blue-200 bg-blue-100 dark:bg-blue-900 rounded">
                                            {{ $course->code }}
                                        </span>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $course->name }}</h3>
                                    @if($course->description)
                                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">{{ \Str::limit($course->description, 100) }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">{{ $course->lessons_count }} Lessons</p>
                                    
                                    <a href="{{ route('student.courses.show', $course) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white text-xs font-semibold rounded hover:bg-blue-700 dark:hover:bg-blue-600 transition">
                                        View Lessons →
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
