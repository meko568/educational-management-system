<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Add Questions to Exam: {{ $exam->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Exam Info Banner -->
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-semibold text-blue-800 dark:text-blue-200">Grade:</span>
                                <span class="text-blue-700 dark:text-blue-300 ml-2">{{ $exam->grade }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-blue-800 dark:text-blue-200">Duration:</span>
                                <span class="text-blue-700 dark:text-blue-300 ml-2">{{ $exam->duration_minutes }} minutes</span>
                            </div>
                            <div>
                                <span class="font-semibold text-blue-800 dark:text-blue-200">Start:</span>
                                <span class="text-blue-700 dark:text-blue-300 ml-2">{{ $exam->start_datetime->format('M d, Y - H:i') }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-blue-800 dark:text-blue-200">End:</span>
                                <span class="text-blue-700 dark:text-blue-300 ml-2">{{ $exam->end_datetime->format('M d, Y - H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.exams.questions.store', $exam->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div id="questions-container">
                            <!-- Question Template -->
                            <div class="question-item mb-8 p-4 border border-gray-200 dark:border-gray-700 rounded-lg" data-question-index="0">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Question 1</h3>
                                    <button type="button" class="remove-question-btn text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm">
                                        Remove
                                    </button>
                                </div>

                                <!-- Question Type -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Type</label>
                                    <select name="questions[0][type]" class="question-type-select block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm" required>
                                        <option value="multiple_choice">Multiple Choice</option>
                                        <option value="true_false">True/False</option>
                                        <option value="fill_blank">Fill in the Blank</option>
                                    </select>
                                </div>

                                <!-- Question Text -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Text</label>
                                    <textarea name="questions[0][question_text]" rows="3" class="block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm" required></textarea>
                                </div>

                                <!-- Question Image -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Image (Optional)</label>
                                    <input type="file" name="questions[0][question_image]" accept="image/*" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Max size: 5MB</p>
                                </div>

                                <!-- Points -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Points</label>
                                    <input type="number" name="questions[0][points]" value="1" min="1" class="block w-24 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm" required>
                                </div>

                                <!-- Choices Container (for multiple choice) -->
                                <div class="choices-container">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Choices</label>
                                    <div class="choice-item mb-2 flex items-center gap-2">
                                        <input type="radio" name="questions[0][correct_choice]" value="0" class="correct-choice-radio" required>
                                        <input type="text" name="questions[0][choices][0][choice_text]" placeholder="Choice A" class="flex-1 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm" required>
                                        <button type="button" class="remove-choice-btn text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm">Remove</button>
                                    </div>
                                    <div class="choice-item mb-2 flex items-center gap-2">
                                        <input type="radio" name="questions[0][correct_choice]" value="1" class="correct-choice-radio">
                                        <input type="text" name="questions[0][choices][1][choice_text]" placeholder="Choice B" class="flex-1 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm" required>
                                        <button type="button" class="remove-choice-btn text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm">Remove</button>
                                    </div>
                                    <div class="choice-item mb-2 flex items-center gap-2">
                                        <input type="radio" name="questions[0][correct_choice]" value="2" class="correct-choice-radio">
                                        <input type="text" name="questions[0][choices][2][choice_text]" placeholder="Choice C" class="flex-1 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm" required>
                                        <button type="button" class="remove-choice-btn text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm">Remove</button>
                                    </div>
                                    <div class="choice-item mb-2 flex items-center gap-2">
                                        <input type="radio" name="questions[0][correct_choice]" value="3" class="correct-choice-radio">
                                        <input type="text" name="questions[0][choices][3][choice_text]" placeholder="Choice D" class="flex-1 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white sm:text-sm" required>
                                        <button type="button" class="remove-choice-btn text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm">Remove</button>
                                    </div>
                                    <button type="button" class="add-choice-btn text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm mt-2">+ Add Choice</button>
                                </div>
                            </div>
                        </div>

                        <!-- Add Question Button -->
                        <button type="button" id="add-question-btn" class="mb-6 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            + Add Question
                        </button>

                        <!-- Submit Button -->
                        <div class="flex justify-between items-center">
                            <a href="{{ route('admin.exams.show', $exam->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Save Questions & Finish
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let questionCount = 1;

        document.getElementById('add-question-btn').addEventListener('click', function() {
            const container = document.getElementById('questions-container');
            const template = document.querySelector('.question-item');
            const clone = template.cloneNode(true);
            
            // Update question index
            clone.setAttribute('data-question-index', questionCount);
            clone.querySelector('h3').textContent = 'Question ' + (questionCount + 1);
            
            // Update all name attributes
            const inputs = clone.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    const newName = name.replace(/\[0\]/, `[${questionCount}]`);
                    input.setAttribute('name', newName);
                }
            });

            // Reset values
            clone.querySelectorAll('input[type="text"], textarea').forEach(input => input.value = '');
            clone.querySelectorAll('input[type="radio"]').forEach(radio => radio.checked = false);
            clone.querySelector('input[type="number"]').value = '1';

            container.appendChild(clone);
            questionCount++;
        });

        // Event delegation for remove buttons
        document.getElementById('questions-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-question-btn')) {
                const questionItem = e.target.closest('.question-item');
                if (document.querySelectorAll('.question-item').length > 1) {
                    questionItem.remove();
                    // Update question numbers
                    document.querySelectorAll('.question-item').forEach((item, index) => {
                        item.querySelector('h3').textContent = 'Question ' + (index + 1);
                        item.setAttribute('data-question-index', index);
                        const inputs = item.querySelectorAll('input, textarea, select');
                        inputs.forEach(input => {
                            const name = input.getAttribute('name');
                            if (name) {
                                const newName = name.replace(/\[\d+\]/, `[${index}]`);
                                input.setAttribute('name', newName);
                            }
                        });
                    });
                    questionCount = document.querySelectorAll('.question-item').length;
                }
            }

            if (e.target.classList.contains('remove-choice-btn')) {
                const choiceItem = e.target.closest('.choice-item');
                const choicesContainer = e.target.closest('.choices-container');
                if (choicesContainer.querySelectorAll('.choice-item').length > 2) {
                    choiceItem.remove();
                }
            }

            if (e.target.classList.contains('add-choice-btn')) {
                const choicesContainer = e.target.closest('.choices-container');
                const questionIndex = e.target.closest('.question-item').getAttribute('data-question-index');
                const choiceCount = choicesContainer.querySelectorAll('.choice-item').length;
                const choiceTemplate = choicesContainer.querySelector('.choice-item');
                const clone = choiceTemplate.cloneNode(true);
                
                clone.querySelector('input[type="text"]').value = '';
                clone.querySelector('input[type="radio"]').value = choiceCount;
                clone.querySelector('input[type="text"]').placeholder = 'Choice ' + String.fromCharCode(65 + choiceCount);
                
                choicesContainer.insertBefore(clone, e.target);
            }
        });

        // Handle question type change
        document.getElementById('questions-container').addEventListener('change', function(e) {
            if (e.target.classList.contains('question-type-select')) {
                const questionItem = e.target.closest('.question-item');
                const choicesContainer = questionItem.querySelector('.choices-container');
                const type = e.target.value;
                
                if (type === 'multiple_choice') {
                    choicesContainer.style.display = 'block';
                    choicesContainer.querySelectorAll('input').forEach(input => input.required = true);
                } else {
                    choicesContainer.style.display = 'none';
                    choicesContainer.querySelectorAll('input').forEach(input => input.required = false);
                }
            }
        });
    </script>
</x-app-layout>
