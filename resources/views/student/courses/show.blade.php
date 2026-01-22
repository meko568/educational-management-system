<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $course->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Course Code: {{ $course->code }}</p>
                        @if($course->description)
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded border border-gray-200 dark:border-gray-600">
                                <p class="text-gray-700 dark:text-gray-300">{{ $course->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Access Status Alert -->
                    @if(!$hasAccess)
                        <div class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                            <div class="flex items-start">
                                <div class="flex-1">
                                    <h3 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">⚠️ Limited Access</h3>
                                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">Your subscription has expired. You cannot access the lesson content (videos and PDFs).</p>
                                    <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-2">Please contact your instructor to renew your subscription.</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg">
                            <p class="text-sm text-green-700 dark:text-green-300">✓ You have access to all content until <span class="font-semibold">{{ $student->getSubscriptionExpiryDate()->format('F d, Y') }}</span></p>
                        </div>
                    @endif

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Lessons ({{ $lessons->count() }})</h3>

                        @if($lessons->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">No lessons available in this course yet.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($lessons as $lesson)
                                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition bg-gray-50 dark:bg-gray-700">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                        Lesson {{ $lesson->order + 1 }}
                                                    </span>
                                                    <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ $lesson->title }}</h4>
                                                </div>
                                                @if($lesson->description)
                                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">{{ $lesson->description }}</p>
                                                @endif
                                                
                                                <div class="mt-3 flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                                    @if($lesson->video_url)
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path></svg>
                                                            Video
                                                        </span>
                                                    @endif
                                                    @if($lesson->pdf_url)
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a2 2 0 012-2h4a1 1 0 01.707.293l4 4a1 1 0 01.293.707v10a2 2 0 01-2 2H10a1 1 0 110-2h6V9h-3a1 1 0 01-1-1V5H10v7a1 1 0 11-2 0V4z" clip-rule="evenodd"></path></svg>
                                                            PDF
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            @if($hasAccess)
                                                <a href="{{ route('student.lessons.show', [$course, $lesson]) }}" class="ml-4 inline-flex items-center px-3 py-2 bg-blue-600 dark:bg-blue-700 text-white text-xs font-semibold rounded hover:bg-blue-700 dark:hover:bg-blue-600 transition whitespace-nowrap">
                                                    Open Lesson
                                                </a>
                                            @else
                                                <div class="ml-4 inline-flex items-center px-3 py-2 bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-400 text-xs font-semibold rounded cursor-not-allowed whitespace-nowrap" title="Your subscription has expired">
                                                    Locked 🔒
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
