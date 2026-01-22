@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">{{ $course->name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">الكود: {{ $course->code }}</p>
                        @if($course->description)
                            <p class="text-sm text-gray-600 mt-2">{{ $course->description }}</p>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.courses.index', $academicYear) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            العودة إلى الدورات
                        </a>
                        <a href="{{ route('admin.courses.lessons.create', [$academicYear, $course]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            إضافة درس
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p class="font-bold">تم بنجاح</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">الدروس ({{ count($lessons) }})</h3>

                    @if($lessons->isEmpty())
                        <p class="text-gray-500 text-center py-8">لا توجد دروس بعد. أنشئ درسًا للبدء!</p>
                    @else
                        <div class="space-y-4">
                            @foreach($lessons as $lesson)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3">
                                                <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                                                    الترتيب: {{ $lesson->order }}
                                                </span>
                                                <h4 class="text-lg font-semibold text-gray-800">{{ $lesson->title }}</h4>
                                            </div>
                                            @if($lesson->description)
                                                <p class="text-sm text-gray-600 mt-2">{{ $lesson->description }}</p>
                                            @endif
                                            <div class="mt-3 space-y-2">
                                                @if($lesson->video_url)
                                                    <div class="flex items-center gap-2 text-sm text-blue-600">
                                                        <span class="font-medium">📹 فيديو:</span>
                                                        <a href="{{ $lesson->video_url }}" target="_blank" class="hover:underline truncate">
                                                            {{ \Str::limit($lesson->video_url, 50) }}
                                                        </a>
                                                    </div>
                                                @endif
                                                @if($lesson->pdf_url)
                                                    <div class="flex items-center gap-2 text-sm text-red-600">
                                                        <span class="font-medium">📄 PDF:</span>
                                                        <a href="{{ $lesson->pdf_url }}" target="_blank" class="hover:underline truncate">
                                                            {{ \Str::limit($lesson->pdf_url, 50) }}
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.courses.lessons.edit', [$academicYear, $course, $lesson]) }}" class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200">
                                                تعديل
                                            </a>
                                            <form method="POST" action="{{ route('admin.courses.lessons.destroy', [$academicYear, $course, $lesson]) }}" style="display:inline;" onsubmit="return confirm('هل أنت متأكد؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200">
                                                    حذف
                                                </button>
                                            </form>
                                        </div>
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
@endsection
