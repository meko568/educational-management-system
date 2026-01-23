<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $lesson->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            الدورة: <a href="{{ route('student.courses.show', $course) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $course->name }}</a>
                        </p>
                    </div>

                    <!-- Access Control Check -->
                    @if(!$hasAccess)
                        <div class="mb-6 p-6 bg-red-50 dark:bg-red-900 border-2 border-red-200 dark:border-red-700 rounded-lg text-center">
                            <div class="mb-4">
                                <span class="text-4xl">🔒</span>
                            </div>
                            <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2">الوصول مرفوض</h3>
                            <p class="text-red-700 dark:text-red-300 mb-4">انتهت صلاحية اشتراكك. لا يمكنك الوصول إلى محتوى هذا الدرس.</p>
                            <div class="space-y-2 text-sm text-red-600 dark:text-red-400 mb-6">
                                <p>📅 انتهت صلاحية اشتراكك في: <span class="font-semibold">{{ $student->getSubscriptionExpiryDate()->format('F d, Y') }}</span></p>
                                <p>يرجى التواصل مع معلمك لتجديد اشتراكك.</p>
                            </div>
                            <a href="{{ route('student.courses.index') }}" class="inline-flex items-center px-4 py-2 bg-red-600 dark:bg-red-700 text-white rounded hover:bg-red-700 dark:hover:bg-red-600">
                                العودة إلى الدورات
                            </a>
                        </div>
                    @else
                        <!-- Active Subscription -->
                        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg">
                            <p class="text-sm text-green-700 dark:text-green-300">
                                ✓ لديك وصول إلى هذا المحتوى حتى <span class="font-semibold">{{ $student->getSubscriptionExpiryDate()->format('F d, Y') }}</span>
                            </p>
                        </div>

                        <!-- Lesson Description -->
                        @if($lesson->description)
                            <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded border border-gray-200 dark:border-gray-600">
                                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">حول هذا الدرس</h3>
                                <p class="text-gray-700 dark:text-gray-300">{{ $lesson->description }}</p>
                            </div>
                        @endif

                        <div class="space-y-8">
                            <!-- Video Section -->
                            @if($lesson->video_url)
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                                    <div class="bg-black aspect-video flex items-center justify-center">
                                        <div class="text-center text-white">
                                            <div class="mb-4">
                                                <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path></svg>
                                            </div>
                                            <p class="mb-4">مشغل الفيديو</p>
                                            <a href="{{ $lesson->video_url }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-blue-600 dark:bg-blue-700 text-white font-semibold rounded hover:bg-blue-700 dark:hover:bg-blue-600 transition">
                                                ► فتح الفيديو في علامة تبويب جديدة
                                            </a>
                                        </div>
                                    </div>
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700">
                                        <p class="text-xs text-gray-600 dark:text-gray-400">رابط الفيديو: <code class="text-xs bg-gray-100 dark:bg-gray-600 px-2 py-1 rounded">{{ $lesson->video_url }}</code></p>
                                    </div>
                                </div>
                            @endif

                            <!-- PDF Section -->
                            @if($lesson->pdf_url)
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-6 bg-gray-50 dark:bg-gray-700">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0">
                                            <svg class="w-12 h-12 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a2 2 0 012-2h4a1 1 0 01.707.293l4 4a1 1 0 01.293.707v10a2 2 0 01-2 2H10a1 1 0 110-2h6V9h-3a1 1 0 01-1-1V5H10v7a1 1 0 11-2 0V4z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">مادة الدورة (PDF)</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">قم بتنزيل مادة الدورة والوثائق المرجعية.</p>
                                            <a href="{{ $lesson->pdf_url }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 dark:bg-red-700 text-white font-semibold rounded hover:bg-red-700 dark:hover:bg-red-600 transition">
                                                📥 تنزيل PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- No Content Warning -->
                            @if(!$lesson->video_url && !$lesson->pdf_url)
                                <div class="p-6 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg text-center">
                                    <p class="text-yellow-700 dark:text-yellow-300">⚠️ لم تتم إضافة محتوى فيديو أو PDF إلى هذا الدرس بعد.</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Navigation -->
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-600 flex justify-between">
                        <a href="{{ route('student.courses.show', $course) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            ← العودة إلى الدروس
                        </a>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            الدرس {{ $lesson->order + 1 }} من {{ $lessonsCount }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
