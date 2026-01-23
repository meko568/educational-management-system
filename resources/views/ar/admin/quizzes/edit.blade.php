@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200" style="direction: rtl;">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">تعديل الاختبار القصير</h2>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.quizzes.update', $quiz->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="academicYear" value="{{ $academicYear ?? 'primary1' }}">

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700">العنوان</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $quiz->title) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700">الوصف</label>
                        <textarea id="description" name="description" rows="4" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $quiz->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Exam Selection -->
                    <div class="mb-6">
                        <label for="exam_id" class="block text-sm font-medium text-gray-700">الاختبار (اختياري)</label>
                        <select id="exam_id" name="exam_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">-- اختر اختبار --</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" {{ old('exam_id', $quiz->exam_id) == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('exam_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Total Marks -->
                    <div class="mb-6">
                        <label for="total_marks" class="block text-sm font-medium text-gray-700">الدرجة الكلية</label>
                        <input type="number" id="total_marks" name="total_marks" value="{{ old('total_marks', $quiz->total_marks) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        @error('total_marks')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <label for="status" class="block text-sm font-medium text-gray-700">الحالة</label>
                        <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            <option value="draft" {{ old('status', $quiz->status) === 'draft' ? 'selected' : '' }}>مسودة</option>
                            <option value="published" {{ old('status', $quiz->status) === 'published' ? 'selected' : '' }}>منشور</option>
                            <option value="archived" {{ old('status', $quiz->status) === 'archived' ? 'selected' : '' }}>مؤرشف</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-between items-center">
                        <a href="{{ route('admin.quizzes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            رجوع
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            تحديث الاختبار القصير
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
