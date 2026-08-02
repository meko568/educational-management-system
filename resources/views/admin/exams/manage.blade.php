@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-stone-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-stone-800">{{ __('messages.manage_exams_title') }}</h2>
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-stone-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-stone-700">
                        {{ __('messages.back_to_dashboard') }}
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p class="font-bold">{{ __('messages.success') }}</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Create Exam Section -->
                <div class="mb-8 p-6 bg-orange-50 rounded-lg border border-orange-200">
                    <h3 class="text-lg font-semibold text-stone-800 mb-4">{{ __('messages.create_new_exam') }}</h3>

                    <form method="POST" action="{{ route('admin.manual-exams.store') }}">
                        @csrf
                        <input type="hidden" name="academicYear" value="{{ $academicYear ?? 'primary1' }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Exam Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-stone-700">{{ __('messages.exam_title') }}</label>
                                <input type="text" id="title" name="title"
                                       class="mt-1 block w-full px-3 py-2 border border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                       required>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Max Score -->
                            <div>
                                <label for="total_marks" class="block text-sm font-medium text-stone-700">{{ __('messages.max_score') }}</label>
                                <input type="number" id="total_marks" name="total_marks" min="1"
                                       class="mt-1 block w-full px-3 py-2 border border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                       required>
                                @error('total_marks')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Exam Date -->
                            <div>
                                <label for="exam_date" class="block text-sm font-medium text-stone-700">{{ __('messages.exam_date') }}</label>
                                <input type="date" id="exam_date" name="exam_date"
                                       value="{{ now()->format('Y-m-d') }}"
                                       class="mt-1 block w-full px-3 py-2 border border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                       required>
                                @error('exam_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-stone-700">{{ __('messages.status') }}</label>
                                <select id="status" name="status"
                                        class="mt-1 block w-full px-3 py-2 border border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                        required>
                                    <option value="">{{ __('messages.select_status') }}</option>
                                    <option value="draft">{{ __('messages.draft') }}</option>
                                    <option value="scheduled">{{ __('messages.scheduled') }}</option>
                                    <option value="in_progress">{{ __('messages.in_progress') }}</option>
                                    <option value="completed">{{ __('messages.completed') }}</option>
                                    <option value="cancelled">{{ __('messages.cancelled') }}</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-stone-700">{{ __('messages.description') }}</label>
                                <textarea id="description" name="description" rows="3"
                                          class="mt-1 block w-full px-3 py-2 border border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"></textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="md:col-span-2">
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700">
                                    {{ __('messages.create_exam_button') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Record Results Section -->
                <div class="mb-8 p-6 bg-orange-50 rounded-lg border border-orange-200">
                    <h3 class="text-lg font-semibold text-stone-800 mb-4">{{ __('messages.record_student_results') }}</h3>

                    <form method="POST" id="recordForm" action="">
                        @csrf
                        <input type="hidden" name="academicYear" value="{{ $academicYear ?? 'primary1' }}">

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Select Exam -->
                            <div>
                                <label for="exam_select" class="block text-sm font-medium text-stone-700">{{ __('messages.select_exam') }}</label>
                                <select id="exam_select"
                                        class="mt-1 block w-full px-3 py-2 border border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                        onchange="loadExamForm()" required>
                                    <option value="">{{ __('messages.select_exam_placeholder') }}</option>
                                    @foreach($exams as $exam)
                                        <option value="{{ $exam->id }}"
                                                data-max-marks="{{ $exam->total_marks }}"
                                                {{ $latestExam && $exam->id === $latestExam->id ? 'selected' : '' }}>
                                            {{ $exam->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Max Score (Read-only) -->
                            <div>
                                <label for="max_score_display" class="block text-sm font-medium text-stone-700">{{ __('messages.max_score') }}</label>
                                <input type="number" id="max_score_display"
                                       class="mt-1 block w-full px-3 py-2 border border-stone-300 rounded-md bg-stone-100 sm:text-sm"
                                       readonly>
                            </div>

                            <!-- Student Code -->
                            <div>
                                <label for="student_code" class="block text-sm font-medium text-stone-700">{{ __('messages.student_code') }}</label>
                                <select id="student_code" name="student_code"
                                        class="mt-1 block w-full px-3 py-2 border border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                        required>
                                    <option value="">{{ __('messages.select_student_placeholder') }}</option>
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

                            <!-- Student Result -->
                            <div>
                                <label for="marks_obtained" class="block text-sm font-medium text-stone-700">{{ __('messages.student_result') }}</label>
                                <input type="number" id="marks_obtained" name="marks_obtained" min="0"
                                       class="mt-1 block w-full px-3 py-2 border border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                       placeholder="0" required>
                                @error('marks_obtained')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="md:col-span-4">
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700">
                                    {{ __('messages.save_result_button') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Results Table -->
                <h3 class="text-lg font-semibold text-stone-800 mb-4">{{ __('messages.all_exam_results') }}</h3>

                @if($allResults->count() > 0)
                    <div class="overflow-x-auto mb-8">
                        <table class="min-w-full divide-y divide-stone-200">
                            <thead class="bg-stone-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">{{ __('messages.exam') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">{{ __('messages.student_code') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">{{ __('messages.student_name') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">{{ __('messages.result') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">{{ __('messages.max_score') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">{{ __('messages.percentage') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-stone-200">
                                @foreach($allResults as $result)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-900">{{ $result->exam->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-900">{{ $result->student->code }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-900">{{ $result->student->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ $result->marks_obtained }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-900">{{ $result->exam->total_marks }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-900">
                                            {{ number_format(($result->marks_obtained / $result->exam->total_marks) * 100, 2) }}%
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                            <form action="{{ route('admin.exams.deleteResult', [$result->exam_id, $result->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('{{ __('messages.delete_confirm') }}')"
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                                                    {{ __('messages.delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-stone-500 mb-8">
                        <p>{{ __('messages.no_records') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function loadExamForm() {
    const examSelect = document.getElementById('exam_select');
    const examId = examSelect.value;
    const selectedOption = examSelect.options[examSelect.selectedIndex];
    const maxScore = selectedOption.getAttribute('data-max-marks');
    const maxScoreDisplay = document.getElementById('max_score_display');
    const recordForm = document.getElementById('recordForm');

    if (!examId) {
        maxScoreDisplay.value = '';
        recordForm.action = '';
        return;
    }

    maxScoreDisplay.value = maxScore;
    document.getElementById('marks_obtained').max = maxScore;
    recordForm.action = '{{ route("admin.manual-exams.storeResult", ":id") }}'.replace(':id', examId);
}

document.addEventListener('DOMContentLoaded', function() {
    const examSelect = document.getElementById('exam_select');
    if (examSelect && examSelect.value) {
        loadExamForm();
    }
});
</script>
@endsection
