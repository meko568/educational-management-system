<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $attempt->quiz->title }}
            </h2>
            <div class="flex items-center space-x-4">
                <div id="timer" class="px-4 py-2 bg-red-100 dark:bg-red-900 border border-red-300 dark:border-red-700 rounded-lg">
                    <span class="text-red-800 dark:text-red-200 font-semibold">
                        Time Remaining: <span id="time-display">{{ $remainingTime }}</span> minutes
                    </span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Quiz Info -->
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-semibold text-blue-800 dark:text-blue-200">Questions:</span>
                                <span class="text-blue-700 dark:text-blue-300 ml-2">{{ $questions->count() }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-blue-800 dark:text-blue-200">Total Points:</span>
                                <span class="text-blue-700 dark:text-blue-300 ml-2">{{ $attempt->total_points }}</span>
                            </div>
                        </div>
                    </div>

                    <form id="quiz-form" action="{{ route('student.quizzes.submit', $attempt->id) }}" method="POST">
                        @csrf
                        
                        <div id="questions-container">
                            @foreach($questions as $index => $question)
                                <div class="question-item mb-8 p-4 border border-gray-200 dark:border-gray-700 rounded-lg" data-question-id="{{ $question->id }}">
                                    <div class="mb-4">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                                            Question {{ $index + 1 }} ({{ $question->points }} points)
                                        </h3>
                                        <p class="text-gray-700 dark:text-gray-300">{{ $question->question_text }}</p>
                                        @if($question->question_image)
                                            <img src="{{ $question->question_image }}" alt="Question Image" class="mt-4 max-w-md rounded-lg">
                                        @endif
                                    </div>

                                    @if($question->type === 'multiple_choice')
                                        <div class="space-y-3">
                                            @foreach($question->choices as $choice)
                                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    <input type="radio" 
                                                           name="question_{{ $question->id }}" 
                                                           value="{{ $choice->id }}" 
                                                           class="choice-radio h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                                                           @if(isset($existingAnswers[$question->id]) && $existingAnswers[$question->id]->choice_id == $choice->id) checked @endif
                                                           onchange="saveAnswer({{ $question->id }}, {{ $choice->id }}, null)">
                                                    <span class="ml-3 text-gray-700 dark:text-gray-300">{{ $choice->choice_text }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @elseif($question->type === 'true_false')
                                        <div class="space-y-3">
                                            <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <input type="radio" 
                                                       name="question_{{ $question->id }}" 
                                                       value="true" 
                                                       class="choice-radio h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                                                       @if(isset($existingAnswers[$question->id]) && $existingAnswers[$question->id]->choice_id) checked @endif
                                                       onchange="saveAnswer({{ $question->id }}, 'true', null)">
                                                <span class="ml-3 text-gray-700 dark:text-gray-300">True</span>
                                            </label>
                                            <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <input type="radio" 
                                                       name="question_{{ $question->id }}" 
                                                       value="false" 
                                                       class="choice-radio h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                                                       onchange="saveAnswer({{ $question->id }}, 'false', null)">
                                                <span class="ml-3 text-gray-700 dark:text-gray-300">False</span>
                                            </label>
                                        </div>
                                    @elseif($question->type === 'fill_blank')
                                        <div>
                                            <input type="text" 
                                                   name="question_{{ $question->id }}" 
                                                   placeholder="Type your answer here..."
                                                   class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm"
                                                   value="{{ isset($existingAnswers[$question->id]) ? $existingAnswers[$question->id]->text_answer : '' }}"
                                                   onchange="saveAnswer({{ $question->id }}, null, this.value)">
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700">
                                Submit Quiz
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let remainingTime = {{ $remainingTime }};
        const timerDisplay = document.getElementById('time-display');
        const quizForm = document.getElementById('quiz-form');
        let timerInterval;

        function updateTimer() {
            remainingTime--;
            timerDisplay.textContent = remainingTime;
            
            if (remainingTime <= 0) {
                clearInterval(timerInterval);
                quizForm.submit();
            }
        }

        // Start timer
        timerInterval = setInterval(updateTimer, 60000); // Update every minute

        // Auto-save answers
        async function saveAnswer(questionId, choiceId, textAnswer) {
            const formData = new FormData();
            formData.append('question_id', questionId);
            if (choiceId) {
                formData.append('choice_id', choiceId);
            }
            if (textAnswer) {
                formData.append('text_answer', textAnswer);
            }

            try {
                const response = await fetch('{{ route('student.quizzes.save-answer', $attempt->id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData
                });
                
                if (!response.ok) {
                    console.error('Failed to save answer');
                }
            } catch (error) {
                console.error('Error saving answer:', error);
            }
        }

        // Warn before leaving
        window.addEventListener('beforeunload', function(e) {
            e.preventDefault();
            e.returnValue = '';
        });

        // Clear timer when page unloads
        window.addEventListener('unload', function() {
            clearInterval(timerInterval);
        });
    </script>
</x-app-layout>
