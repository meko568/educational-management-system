<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Exam Result: {{ $attempt->exam->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Score Summary -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                            Your Score: {{ number_format($attempt->score, 1) }}%
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ $attempt->earned_points }} out of {{ $attempt->total_points }} points
                        </p>
                        @if($attempt->status === 'timed_out')
                            <p class="mt-2 text-red-600 dark:text-red-400 font-medium">
                                Time expired - exam was submitted automatically
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detailed Results -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Question Details</h3>
                    
                    @foreach($attempt->exam->questions as $index => $question)
                        <div class="mb-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg @if($attempt->answers->where('question_id', $question->id)->first()->is_correct ?? false) bg-green-50 dark:bg-green-900 @else bg-red-50 dark:bg-red-900 @endif">
                            <div class="flex items-start justify-between mb-3">
                                <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">
                                    Question {{ $index + 1 }} ({{ $question->points }} points)
                                </h4>
                                @php
                                    $answer = $attempt->answers->where('question_id', $question->id)->first();
                                    $isCorrect = $answer ? $answer->is_correct : false;
                                @endphp
                                @if($isCorrect)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Correct
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Incorrect
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-gray-700 dark:text-gray-300 mb-3">{{ $question->question_text }}</p>
                            
                            @if($question->question_image)
                                <img src="{{ $question->question_image }}" alt="Question Image" class="mb-3 max-w-md rounded-lg">
                            @endif

                            @if($question->type === 'multiple_choice')
                                <div class="space-y-2">
                                    @foreach($question->choices as $choice)
                                        <div class="flex items-center p-2 rounded @if($choice->is_correct) bg-green-200 dark:bg-green-800 @elseif($answer && $answer->choice_id == $choice->id) bg-red-200 dark:bg-red-800 @endif">
                                            <span class="text-gray-700 dark:text-gray-300">
                                                {{ $choice->choice_text }}
                                                @if($choice->is_correct)
                                                    <span class="ml-2 text-green-600 dark:text-green-400 font-medium">(Correct Answer)</span>
                                                @endif
                                                @if($answer && $answer->choice_id == $choice->id && !$choice->is_correct)
                                                    <span class="ml-2 text-red-600 dark:text-red-400 font-medium">(Your Answer)</span>
                                                @endif
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif($question->type === 'true_false')
                                <div class="space-y-2">
                                    <div class="flex items-center p-2 rounded @if($question->choices->where('choice_text', 'true')->first()->is_correct) bg-green-200 dark:bg-green-800 @elseif($answer && $answer->text_answer === 'true') bg-red-200 dark:bg-red-800 @endif">
                                        <span class="text-gray-700 dark:text-gray-300">
                                            True
                                            @if($question->choices->where('choice_text', 'true')->first()->is_correct)
                                                <span class="ml-2 text-green-600 dark:text-green-400 font-medium">(Correct Answer)</span>
                                            @endif
                                            @if($answer && $answer->text_answer === 'true' && !$question->choices->where('choice_text', 'true')->first()->is_correct)
                                                <span class="ml-2 text-red-600 dark:text-red-400 font-medium">(Your Answer)</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex items-center p-2 rounded @if($question->choices->where('choice_text', 'false')->first()->is_correct) bg-green-200 dark:bg-green-800 @elseif($answer && $answer->text_answer === 'false') bg-red-200 dark:bg-red-800 @endif">
                                        <span class="text-gray-700 dark:text-gray-300">
                                            False
                                            @if($question->choices->where('choice_text', 'false')->first()->is_correct)
                                                <span class="ml-2 text-green-600 dark:text-green-400 font-medium">(Correct Answer)</span>
                                            @endif
                                            @if($answer && $answer->text_answer === 'false' && !$question->choices->where('choice_text', 'false')->first()->is_correct)
                                                <span class="ml-2 text-red-600 dark:text-red-400 font-medium">(Your Answer)</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @elseif($question->type === 'fill_blank')
                                <div class="space-y-2">
                                    <div class="p-2 rounded bg-gray-100 dark:bg-gray-700">
                                        <span class="text-gray-700 dark:text-gray-300">
                                            Your Answer: {{ $answer ? $answer->text_answer : 'Not answered' }}
                                        </span>
                                    </div>
                                    @php
                                        $correctAnswer = $question->choices->where('is_correct', true)->first();
                                    @endphp
                                    @if($correctAnswer)
                                        <div class="p-2 rounded bg-green-100 dark:bg-green-800">
                                            <span class="text-gray-700 dark:text-gray-300">
                                                Correct Answer: {{ $correctAnswer->choice_text }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('student.exams.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600">
                    Back to Exams
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
