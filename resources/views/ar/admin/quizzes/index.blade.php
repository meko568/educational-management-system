@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200" style="direction: rtl;">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">إدارة الاختبارات القصيرة</h2>
                    <a href="{{ route('admin.quizzes.create', ['academicYear' => isset($academicYear) ? $academicYear : 'primary1']) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        إنشاء اختبار قصير
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold">نجاح</p>
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">العنوان</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الاختبار</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الدرجة الكلية</th>

                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">أنشأه</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($quizzes as $quiz)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $quiz->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $quiz->exam->title ?? 'غير متوفر' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $quiz->total_marks }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($quiz->status === 'draft') مسودة
                                            @elseif($quiz->status === 'published') منشور
                                            @else مؤرشف
                                            @if($quiz->status === 'draft') bg-gray-100 text-gray-800">
                                            @elseif($quiz->status === 'published') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800
                                    </td>
                                            @elseif($quiz->status === 'published') منشور
                                            @else مؤرشف
                                    </td>
                                            @elseif($quiz->status === 'published') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 
                                        </span>
                                        {{ $quiz->creator->name ?? 'غير متوفر' }}
                                        </a>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2"> 
                                        <a href="{{ route('admin.quizzes.show', $quiz->id) }}"
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                                        </a>
                                        </a>
                                        <a href="{{ route('admin.quizzes.edit', $quiz->id) }}"
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                            تعديل
                                    </td>
                                </tr>
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                                <tr>
                                        </button>
                                    </td>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        لا توجد اختبارات قصيرة. <a href="{{ route('admin.quizzes.create') }}" class="text-indigo-600 hover:text-indigo-900">إنشاء واحد</a>
                </div>

                                </tr>
                            @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

                    {{ $quizzes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function confirmDelete(url) {
    if (confirm('هل أنت متأكد من رغبتك في حذف هذا الاختبار القصير؟')) {
}
        form.method = 'POST';
        form.action = url;
