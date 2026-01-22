@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Create New Lesson</h2>
                    <a href="{{ route('admin.courses.show', [$academicYear, $course]) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Back to Course
                    </a>
                </div>

                <p class="text-sm text-gray-600 mb-6">Course: <span class="font-semibold">{{ $course->name }}</span></p>

                <form method="POST" action="{{ route('admin.courses.lessons.store', [$academicYear, $course]) }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Lesson Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="4"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="video_url" class="block text-sm font-medium text-gray-700">Video URL</label>
                        <input type="url" id="video_url" name="video_url" value="{{ old('video_url') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="https://example.com/video.mp4">
                        <p class="text-xs text-gray-500 mt-1">Enter the full URL of the video (e.g., YouTube, Vimeo, or direct link)</p>
                        @error('video_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="pdf_url" class="block text-sm font-medium text-gray-700">PDF URL</label>
                        <input type="url" id="pdf_url" name="pdf_url" value="{{ old('pdf_url') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="https://example.com/document.pdf">
                        <p class="text-xs text-gray-500 mt-1">Enter the full URL of the PDF document</p>
                        @error('pdf_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700">Order</label>
                        <input type="number" id="order" name="order" value="{{ old('order', 0) }}" min="0"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                               required>
                        <p class="text-xs text-gray-500 mt-1">Lessons will be displayed in ascending order</p>
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Create Lesson
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
