@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200" style="direction: rtl;">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">{{ $exam->title }}</h2>
                        <p class="text-sm text-gray-600 mt-1">الدرجة الكلية: <span class="font-bold">{{ $exam->total_marks }}</span></p>
                    </div>
                    <a href="{{ route('admin.exams.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        رجوع
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-r-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p class="font-bold">نجاح</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Add Result Form -->
                <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">إضافة نتيجة طالب</h3>
                    
                    <form method="POST" action="{{ route('admin.exams.storeResult', $exam->id) }}">
                        @csrf
                        <input type="hidden" name="academicYear" value="{{ $exam->academicYear ?? 'primary1' }}">
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Student Code -->
                            <div>
                                <label for="student_code" class="block text-sm font-medium text-gray-700">كود الطالب</label>
                                <select id="student_code" name="student_code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    <option value="">-- اختر الطالب --</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->code }}">
                                            {{ $student->code }} - {{ $student->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Marks Obtained -->
                            <div>
                                <label for="marks_obtained" class="block text-sm font-medium text-gray-700">الدرجة (0-{{ $exam->total_marks }})</label>
                                <input type="number" id="marks_obtained" name="marks_obtained" min="0" max="{{ $exam->total_marks }}" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('marks_obtained')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-end">
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                    حفظ النتيجة
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Results Table -->
                <h3 class="text-lg font-semibold text-gray-800 mb-4">نتائج الطلاب</h3>
                
                @if($results->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">كود الطالب</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">اسم الطالب</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">النتيجة</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الدرجة الكلية</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">النسبة المئوية</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($results as $result)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $result->student->code }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $result->student->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ $result->marks_obtained }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $exam->total_marks }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ number_format(($result->marks_obtained / $exam->total_marks) * 100, 2) }}%
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                            <form action="{{ route('admin.exams.deleteResult', [$exam->id, $result->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('هل أنت متأكد؟')" 
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                                                    حذف
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>لا توجد نتائج مسجلة حتى الآن.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Initialize select2 for student selection
$(document).ready(function() {
    $('#student_code').select2({
        placeholder: 'ابحث عن طالب...',
        allowClear: true,
        dir: 'rtl'
    });
});
</script>
@endsection