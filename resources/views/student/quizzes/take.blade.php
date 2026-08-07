<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-stone-800 dark:text-stone-200 leading-tight">
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

    <div class="py-12" x-data="{ questionNavOpen: false }" @close-nav.window="questionNavOpen = false">
        <!-- Sidebar - Question Navigation (Mobile & Desktop) -->
        <div x-cloak
             :class="questionNavOpen
                        ? 'translate-x-0 shadow-2xl'
                        : '{{ app()->getLocale() === 'ar' ? 'translate-x-full' : '-translate-x-full' }}'"
             class="fixed inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0' : 'left-0' }} z-[2000] w-72 bg-white dark:bg-stone-800 transition-transform duration-300 ease-in-out shadow-2xl border-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }} border-stone-200 dark:border-stone-700">

            <div class="h-full flex flex-col">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between p-6 border-b border-stone-100 dark:border-stone-700">
                    <h3 class="text-lg font-black uppercase tracking-tight text-stone-900 dark:text-stone-100">Questions</h3>
                    <button @click="questionNavOpen = false" class="p-2 rounded-lg hover:bg-stone-100 dark:hover:bg-stone-700 text-stone-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-4">
                    <div class="bg-white dark:bg-stone-800 overflow-hidden">
                        <div class="p-4">
                            <div id="question-nav" class="space-y-2">
                                <!-- Question navigation items will be added here -->
                            </div>
                        </div>
                        <div class="border-t border-stone-200 dark:border-stone-700 p-4">
                            <button type="submit" form="quiz-form" class="w-full inline-flex items-center justify-center px-4 py-3 bg-orange-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-orange-700 transition-colors shadow-lg shadow-orange-600/20 mb-2">
                                Submit Quiz
                            </button>
                            <div class="text-[10px] font-mono-label font-bold text-stone-400 uppercase tracking-widest text-center mt-2">
                                {{ $attempt->total_points }} total points
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay for Sidebar -->
        <div x-cloak
             x-show="questionNavOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="questionNavOpen = false"
             class="fixed inset-0 bg-stone-900/60 backdrop-blur-sm z-[1900]">
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Question Navigation Toggle Button -->
            <div class="mb-6">
                <button @click="questionNavOpen = true" class="w-full sm:w-auto flex items-center justify-between gap-6 px-6 py-3 bg-white dark:bg-stone-800 border border-stone-200 dark:border-stone-700 rounded-xl shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </div>
                        <span class="font-bold text-stone-700 dark:text-stone-200">Question Navigation</span>
                    </div>
                    <span class="text-xs font-mono-label font-bold text-stone-400 uppercase tracking-widest bg-stone-50 dark:bg-stone-700/50 px-2 py-1 rounded">View All ({{ $questions->count() }})</span>
                </button>
            </div>

            <div class="flex gap-6">
                <!-- Main Content - Question Display -->
                <div class="flex-1">
                    <div class="bg-white dark:bg-stone-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <!-- Quiz Info -->
                            <div class="mb-6 p-4 bg-orange-50 dark:bg-orange-900 border border-orange-200 dark:border-orange-700 rounded-lg">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="font-semibold text-orange-800 dark:text-orange-200">Questions:</span>
                                        <span class="text-orange-700 dark:text-orange-300 ml-2">{{ $questions->count() }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-orange-800 dark:text-orange-200">Total Points:</span>
                                        <span class="text-orange-700 dark:text-orange-300 ml-2">{{ $attempt->total_points }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Modal -->
                            <div id="custom-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-white dark:bg-stone-800 rounded-lg p-6 max-w-md w-full mx-4 shadow-xl">
                                    <h3 id="modal-title" class="text-lg font-semibold text-stone-900 dark:text-stone-100 mb-4">Warning</h3>
                                    <div id="modal-content" class="text-stone-700 dark:text-stone-300 mb-6"></div>
                                    <div class="flex justify-end gap-3">
                                        <button id="modal-cancel-btn" class="px-4 py-2 bg-stone-600 dark:bg-stone-700 text-white rounded-md hover:bg-stone-700 dark:hover:bg-stone-600">Cancel</button>
                                        <button id="modal-confirm-btn" class="px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700">OK</button>
                                    </div>
                                </div>
                            </div>

                            <form id="quiz-form" action="{{ route('student.quizzes.submit', $attempt->id) }}" method="POST">
                                @csrf

                                <div id="questions-container">
                                    @foreach($questions as $index => $question)
                                        <div class="question-item @if($index !== 0) hidden @endif" data-question-index="{{ $index }}" data-question-id="{{ $question->id }}">
                                            <div class="mb-4">
                                                <h3 class="text-lg font-medium text-stone-900 dark:text-stone-100 mb-2">
                                                    Question {{ $index + 1 }} ({{ $question->points }} points)
                                                </h3>
                                                <p class="text-stone-700 dark:text-stone-300">{{ $question->question_text }}</p>
                                                @if($question->question_image)
                                                    <img src="{{ $question->question_image }}" alt="Question Image" class="mt-4 max-w-md rounded-lg">
                                                @endif
                                            </div>

                                            @if($question->type === 'multiple_choice')
                                                <div class="space-y-3">
                                                    @foreach($question->choices as $choice)
                                                        <label class="flex items-center p-3 border border-stone-200 dark:border-stone-600 rounded-lg cursor-pointer hover:bg-stone-50 dark:hover:bg-stone-700">
                                                            <input type="radio"
                                                                   name="question_{{ $question->id }}"
                                                                   value="{{ $choice->id }}"
                                                                   class="choice-radio h-4 w-4 text-orange-600 focus:ring-orange-500"
                                                                   @if(isset($existingAnswers[$question->id]) && $existingAnswers[$question->id]->choice_id == $choice->id) checked @endif
                                                                   onchange="saveAnswer({{ $question->id }}, {{ $choice->id }}, null)">
                                                            <span class="ml-3 text-stone-700 dark:text-stone-300">{{ $choice->choice_text }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @elseif($question->type === 'true_false')
                                                <div class="space-y-3">
                                                    @foreach($question->choices as $choice)
                                                        <label class="flex items-center p-3 border border-stone-200 dark:border-stone-600 rounded-lg cursor-pointer hover:bg-stone-50 dark:hover:bg-stone-700">
                                                            <input type="radio"
                                                                   name="question_{{ $question->id }}"
                                                                   value="{{ $choice->id }}"
                                                                   class="choice-radio h-4 w-4 text-orange-600 focus:ring-orange-500"
                                                                   @if(isset($existingAnswers[$question->id]) && $existingAnswers[$question->id]->choice_id == $choice->id) checked @endif
                                                                   onchange="saveAnswer({{ $question->id }}, {{ $choice->id }}, null)">
                                                            <span class="ml-3 text-stone-700 dark:text-stone-300">{{ $choice->choice_text }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @elseif($question->type === 'fill_blank')
                                                <div>
                                                    <input type="text"
                                                           name="question_{{ $question->id }}"
                                                           placeholder="Type your answer here..."
                                                           class="w-full border-stone-300 dark:border-stone-600 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 dark:bg-stone-700 dark:text-white sm:text-sm"
                                                           value="{{ isset($existingAnswers[$question->id]) ? $existingAnswers[$question->id]->text_answer : '' }}"
                                                           onchange="saveAnswer({{ $question->id }}, null, this.value)">
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="flex justify-between items-center mt-6 pt-6 border-t border-stone-200 dark:border-stone-700">
                                    <button type="button" id="prev-question-btn" class="inline-flex items-center px-4 py-2 bg-stone-600 dark:bg-stone-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-stone-700 dark:hover:bg-stone-600 disabled:bg-stone-800 dark:disabled:bg-stone-900 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                        Previous
                                    </button>
                                    <div class="flex items-center gap-3">
                                        <button type="button" id="next-question-btn" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700">
                                            Next
                                        </button>
                                        <button type="submit" id="bottom-submit-btn" class="hidden inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700">
                                            Submit Quiz
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let remainingTime = {{ $remainingTime }};
        const timerDisplay = document.getElementById('time-display');
        const quizForm = document.getElementById('quiz-form');
        let timerInterval;
        let currentQuestionIndex = 0;
        const totalQuestions = {{ $questions->count() }};

        function updateTimer() {
            remainingTime--;
            timerDisplay.textContent = remainingTime;

            if (remainingTime <= 0) {
                clearInterval(timerInterval);
                quizForm.submit();
            }
        }

        function updateQuestionNav() {
            const nav = document.getElementById('question-nav');
            nav.innerHTML = '';

            document.querySelectorAll('.question-item').forEach((item, index) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                const isAnswered = item.querySelector('input:checked') || item.querySelector('input[type="text"]')?.value;
                btn.className = `w-full text-left px-3 py-2 rounded-md text-sm flex items-center justify-between ${index === currentQuestionIndex ? 'bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-300' : 'bg-stone-100 dark:bg-stone-700 text-stone-700 dark:text-stone-300 hover:bg-stone-200 dark:hover:bg-stone-600'}`;
                btn.innerHTML = `
                    <span>Question ${index + 1}</span>
                    ${isAnswered ? '<span class="text-green-500">✓</span>' : ''}
                `;
                btn.onclick = () => showQuestion(index);
                nav.appendChild(btn);
            });
        }

        function showQuestion(index) {
            const questions = document.querySelectorAll('.question-item');
            if (index < 0 || index >= questions.length) return;

            questions.forEach((q, i) => {
                q.classList.toggle('hidden', i !== index);
            });

            currentQuestionIndex = index;
            updateQuestionNav();
            updateNavButtons();

            window.dispatchEvent(new CustomEvent('close-nav'));
        }

        function updateNavButtons() {
            const prevBtn = document.getElementById('prev-question-btn');
            const nextBtn = document.getElementById('next-question-btn');
            const submitBtn = document.getElementById('bottom-submit-btn');

            prevBtn.disabled = currentQuestionIndex === 0;

            if (currentQuestionIndex === totalQuestions - 1) {
                nextBtn.classList.add('hidden');
                submitBtn.classList.remove('hidden');
            } else {
                nextBtn.classList.remove('hidden');
                submitBtn.classList.add('hidden');
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
                } else {
                    updateQuestionNav(); // Update nav to show answered status
                }
            } catch (error) {
                console.error('Error saving answer:', error);
            }
        }

        document.getElementById('prev-question-btn').addEventListener('click', function() {
            showQuestion(currentQuestionIndex - 1);
        });

        document.getElementById('next-question-btn').addEventListener('click', function() {
            showQuestion(currentQuestionIndex + 1);
        });

        // Validate form before submit
        function validateForm() {
            const questions = document.querySelectorAll('.question-item');
            const unsolvedQuestions = [];

            questions.forEach((question, index) => {
                const questionId = question.getAttribute('data-question-id');
                const hasRadioAnswer = question.querySelector('input[type="radio"]:checked');
                const textAnswer = question.querySelector('input[type="text"]');
                const hasTextAnswer = textAnswer && textAnswer.value.trim();

                if (!hasRadioAnswer && !hasTextAnswer) {
                    unsolvedQuestions.push(index + 1);
                }
            });

            return unsolvedQuestions;
        }

        // Custom Modal Functions
        function showModal(title, content, onConfirm, showCancel = false) {
            const modal = document.getElementById('custom-modal');
            const modalTitle = document.getElementById('modal-title');
            const modalContent = document.getElementById('modal-content');
            const cancelBtn = document.getElementById('modal-cancel-btn');
            const confirmBtn = document.getElementById('modal-confirm-btn');

            modalTitle.textContent = title;
            modalContent.innerHTML = content;
            cancelBtn.classList.toggle('hidden', !showCancel);

            modal.classList.remove('hidden');

            confirmBtn.onclick = function() {
                modal.classList.add('hidden');
                if (onConfirm) onConfirm();
            };

            cancelBtn.onclick = function() {
                modal.classList.add('hidden');
            };
        }

        // Add submit validation
        document.getElementById('quiz-form').addEventListener('submit', function(e) {
            const unsolved = validateForm();

            if (unsolved.length > 0) {
                e.preventDefault();
                showModal(
                    'Unsolved Questions',
                    `You have ${unsolved.length} unsolved question(s): ${unsolved.join(', ')}<br><br>Are you sure you want to submit?`,
                    function() {
                        document.getElementById('quiz-form').submit();
                    },
                    true
                );
            }
        });

        // localStorage Functions
        function saveState() {
            const answers = {};
            document.querySelectorAll('.question-item').forEach((item, index) => {
                const questionId = item.getAttribute('data-question-id');
                const radioAnswer = item.querySelector('input[type="radio"]:checked');
                const textAnswer = item.querySelector('input[type="text"]');

                if (radioAnswer) {
                    answers[questionId] = { type: 'radio', value: radioAnswer.value };
                } else if (textAnswer && textAnswer.value.trim()) {
                    answers[questionId] = { type: 'text', value: textAnswer.value };
                }
            });

            localStorage.setItem('quizTakingState', JSON.stringify({
                answers,
                currentQuestionIndex,
                attemptId: {{ $attempt->id }}
            }));
        }

        function loadState() {
            const saved = localStorage.getItem('quizTakingState');
            if (!saved) return;

            try {
                const state = JSON.parse(saved);

                // Only load if it's the same attempt
                if (state.attemptId !== {{ $attempt->id }}) {
                    localStorage.removeItem('quizTakingState');
                    return;
                }

                // Restore answers
                Object.keys(state.answers).forEach(questionId => {
                    const answer = state.answers[questionId];
                    const questionItem = document.querySelector(`[data-question-id="${questionId}"]`);

                    if (questionItem) {
                        if (answer.type === 'radio') {
                            const radio = questionItem.querySelector(`input[type="radio"][value="${answer.value}"]`);
                            if (radio) radio.checked = true;
                        } else if (answer.type === 'text') {
                            const textInput = questionItem.querySelector('input[type="text"]');
                            if (textInput) textInput.value = answer.value;
                        }
                    }
                });

                currentQuestionIndex = state.currentQuestionIndex;
                showQuestion(currentQuestionIndex);
                updateQuestionNav();

                // Clear saved state
                localStorage.removeItem('quizTakingState');
            } catch (e) {
                console.error('Error loading state:', e);
            }
        }

        // Auto-save state on changes
        document.getElementById('questions-container').addEventListener('change', saveState);

        // Initialize
        loadState();
        updateQuestionNav();
        updateNavButtons();

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
