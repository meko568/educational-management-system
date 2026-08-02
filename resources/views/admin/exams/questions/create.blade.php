<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-stone-800 dark:text-stone-200 leading-tight">
            Add Questions to Exam: {{ $exam->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-6">
                <!-- Sidebar - Question Navigation -->
                <div class="w-64 flex-shrink-0">
                    <div class="bg-white dark:bg-stone-800 overflow-hidden shadow-sm sm:rounded-lg sticky top-4">
                        <div class="p-4">
                            <h3 class="text-lg font-medium text-stone-900 dark:text-stone-100 mb-4">Questions</h3>
                            <div id="question-nav" class="space-y-2 max-h-[60vh] overflow-y-auto">
                                <!-- Question navigation items -->
                            </div>
                            <button type="button" id="add-question-btn" class="mt-4 w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                + Add Question
                            </button>
                        </div>
                        <div class="border-t border-stone-200 dark:border-stone-700 p-4">
                            <!-- Moved Submit Button Inside Sidebar but it still triggers the form -->
                            <button type="submit" form="exam-form" class="w-full inline-flex items-center justify-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 mb-2">
                                Save & Finish
                            </button>
                            <a href="{{ route('admin.exams.index') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-stone-600 dark:bg-stone-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-stone-700 dark:hover:bg-stone-600">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Content - Question Editor -->
                <div class="flex-1">
                    <div class="bg-white dark:bg-stone-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <!-- Errors Display -->
                            @if ($errors->any())
                                <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 rounded">
                                    <p class="font-bold mb-2">Please fix the following errors:</p>
                                    <ul class="list-disc list-inside text-sm">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Custom Modal -->
                            <div id="custom-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-white dark:bg-stone-800 rounded-lg p-6 max-w-md w-full mx-4 shadow-xl border border-stone-200 dark:border-stone-700">
                                    <h3 id="modal-title" class="text-lg font-bold text-red-600 dark:text-red-400 mb-4">Warning</h3>
                                    <div id="modal-content" class="text-stone-700 dark:text-stone-300 mb-6 space-y-2"></div>
                                    <div class="flex justify-end">
                                        <button id="modal-close-btn" class="px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 transition-colors font-medium">OK</button>
                                    </div>
                                </div>
                            </div>

                            <form id="exam-form" method="POST" action="{{ route('admin.exams.questions.store', $exam->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div id="questions-container">
                                    <!-- Questions dynamically injected here -->
                                </div>

                                <!-- Bottom Navigation -->
                                <div class="flex justify-between items-center mt-8 pt-6 border-t border-stone-200 dark:border-stone-700">
                                    <button type="button" id="prev-question-btn" class="inline-flex items-center px-4 py-2 bg-stone-600 text-white rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-stone-700 disabled:opacity-50 transition-opacity">
                                        Previous
                                    </button>
                                    <span class="text-sm font-medium text-stone-500 dark:text-stone-400">
                                        Question <span id="current-display-num">1</span> of <span id="total-display-num">1</span>
                                    </span>
                                    <button type="button" id="next-question-btn" class="inline-flex items-center px-4 py-2 bg-stone-600 text-white rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-stone-700 disabled:opacity-50 transition-opacity">
                                        Next
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- HTML Template for a Question -->
    <template id="q-tpl">
        <div class="question-block space-y-6" data-idx="IDX">
            <div class="flex justify-between items-center border-b border-stone-200 dark:border-stone-700 pb-4">
                <h3 class="text-xl font-bold text-stone-900 dark:text-white text-orange-600">Question #<span class="q-num">1</span></h3>
                <button type="button" class="del-q-btn text-red-500 hover:text-red-700 text-sm font-medium flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Remove
                </button>
            </div>

            <!-- Type Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-stone-700 dark:text-stone-300 mb-1">Question Type</label>
                    <select name="questions[IDX][type]" class="q-type-select block w-full rounded-md border-stone-300 dark:border-stone-600 dark:bg-stone-700 dark:text-white shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        <option value="multiple_choice">Multiple Choice</option>
                        <option value="true_false">True / False</option>
                        <option value="fill_blank">Fill in the Blank</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-stone-700 dark:text-stone-300 mb-1">Points</label>
                    <input type="number" name="questions[IDX][points]" value="1" min="1" class="block w-full rounded-md border-stone-300 dark:border-stone-600 dark:bg-stone-700 dark:text-white shadow-sm focus:border-orange-500 focus:ring-orange-500">
                </div>
            </div>

            <!-- Question Text -->
            <div>
                <label class="block text-sm font-semibold text-stone-700 dark:text-stone-300 mb-1">Question Content</label>
                <textarea name="questions[IDX][question_text]" rows="3" class="block w-full rounded-md border-stone-300 dark:border-stone-600 dark:bg-stone-700 dark:text-white shadow-sm focus:border-orange-500 focus:ring-orange-500" placeholder="Type your question here..."></textarea>
            </div>

            <!-- Question Image -->
            <div>
                <label class="block text-sm font-semibold text-stone-700 dark:text-stone-300 mb-1">Optional Image</label>
                <input type="file" name="questions[IDX][question_image]" class="block w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 dark:file:bg-orange-900 dark:file:text-orange-300">
            </div>

            <!-- Containers for different types -->
            <div class="q-options-area bg-white dark:bg-stone-800 p-4 rounded-md border border-stone-100 dark:border-stone-700">
                <!-- Multiple Choice -->
                <div class="mc-box space-y-4">
                    <label class="block text-sm font-bold text-stone-700 dark:text-stone-200 mb-2">Choices (Select the circle for the correct answer)</label>
                    <div class="choices-list space-y-2">
                        <!-- Choices added via JS -->
                    </div>
                    <button type="button" class="add-choice-btn inline-flex items-center text-orange-600 hover:text-orange-800 text-sm font-bold gap-1 mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Add Choice
                    </button>
                </div>

                <!-- True/False -->
                <div class="tf-box hidden">
                    <label class="block text-sm font-bold text-stone-700 dark:text-stone-200 mb-3">Correct Answer</label>
                    <div class="flex gap-8">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" name="questions[IDX][correct_answer_tf]" value="true" class="h-5 w-5 text-orange-600 focus:ring-orange-500 border-stone-300">
                            <span class="text-stone-700 dark:text-stone-300 group-hover:text-orange-600 font-medium">True</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" name="questions[IDX][correct_answer_tf]" value="false" class="h-5 w-5 text-orange-600 focus:ring-orange-500 border-stone-300">
                            <span class="text-stone-700 dark:text-stone-300 group-hover:text-orange-600 font-medium">False</span>
                        </label>
                    </div>
                </div>

                <!-- Fill Blank -->
                <div class="blank-box hidden">
                    <label class="block text-sm font-bold text-stone-700 dark:text-stone-200 mb-1">Correct Answer (Exact Match)</label>
                    <input type="text" name="questions[IDX][correct_answer_text]" class="block w-full rounded-md border-stone-300 dark:border-stone-600 dark:bg-stone-700 dark:text-white shadow-sm focus:border-orange-500 focus:ring-orange-500" placeholder="Type the exact answer students must write...">
                    <p class="text-[10px] text-stone-500 mt-1 italic">Students must type this text exactly to get points.</p>
                </div>
            </div>
        </div>
    </template>

    <script>
        const container = document.getElementById('questions-container');
        const tpl = document.getElementById('q-tpl');
        const STORAGE_KEY = `admin_exam_persist_{{ $exam->id }}`;
        let questionCounter = 0;
        let activeIdx = 0;

        function saveToLocal() {
            const data = [];
            document.querySelectorAll('.question-block').forEach((block) => {
                const type = block.querySelector('.q-type-select').value;
                const choices = [];
                block.querySelectorAll('.choice-item input[type="text"]').forEach(input => choices.push(input.value));

                data.push({
                    text: block.querySelector('textarea').value,
                    type: type,
                    points: block.querySelector('input[type="number"]').value,
                    tf: block.querySelector('input[value="true"]').checked ? 'true' : (block.querySelector('input[value="false"]').checked ? 'false' : null),
                    blank: block.querySelector('.blank-box input').value,
                    mc_correct: block.querySelector('.correct-choice-radio:checked')?.value,
                    choices: choices
                });
            });
            localStorage.setItem(STORAGE_KEY, JSON.stringify({ questions: data, activeIdx }));
        }

        function renderNav() {
            const nav = document.getElementById('question-nav');
            const blocks = document.querySelectorAll('.question-block');
            nav.innerHTML = '';
            blocks.forEach((b, i) => {
                // Update question number title inside the block
                const qNumSpan = b.querySelector('.q-num');
                if (qNumSpan) qNumSpan.textContent = i + 1;

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = `w-full text-left px-3 py-2 rounded-md text-sm transition-all ${i === activeIdx ? 'bg-orange-600 text-white font-bold shadow-md' : 'bg-stone-100 dark:bg-stone-700 text-stone-700 dark:text-stone-300 hover:bg-stone-200'}`;
                btn.textContent = `Question ${i + 1}`;
                btn.onclick = () => showQuestion(i);
                nav.appendChild(btn);
            });
            document.getElementById('current-display-num').textContent = activeIdx + 1;
            document.getElementById('total-display-num').textContent = blocks.length;

            const prev = document.getElementById('prev-question-btn');
            const next = document.getElementById('next-question-btn');
            prev.disabled = activeIdx === 0;
            next.disabled = activeIdx >= blocks.length - 1;
        }

        function showQuestion(idx) {
            const blocks = document.querySelectorAll('.question-block');
            blocks.forEach((b, i) => b.style.display = (i === idx ? 'block' : 'none'));
            activeIdx = idx;
            renderNav();
        }

        function createChoice(qIdx, cIdx, val = '') {
            const div = document.createElement('div');
            div.className = 'choice-item flex items-center gap-2';
            div.innerHTML = `
                <input type="radio" name="questions[${qIdx}][correct_choice]" value="${cIdx}" class="correct-choice-radio h-4 w-4 text-orange-600">
                <input type="text" name="questions[${qIdx}][choices][${cIdx}][choice_text]" value="${val.replace(/"/g, '&quot;')}" placeholder="Choice ${String.fromCharCode(65 + cIdx)}" class="flex-1 rounded-md border-stone-300 dark:border-stone-600 dark:bg-stone-700 dark:text-white shadow-sm text-sm">
                <button type="button" class="del-choice text-red-500 hover:text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            `;
            return div;
        }

        function addQuestion(data = null) {
            const qIdx = questionCounter++;
            const clone = tpl.content.cloneNode(true);
            const block = clone.querySelector('.question-block');

            // Replace IDX in names
            block.querySelectorAll('[name*="IDX"]').forEach(el => {
                el.name = el.name.replace('IDX', qIdx);
            });
            block.setAttribute('data-idx', qIdx);

            if (data) {
                block.querySelector('textarea').value = data.text;
                block.querySelector('.q-type-select').value = data.type;
                block.querySelector('input[type="number"]').value = data.points;
                block.querySelector('.blank-box input').value = data.blank || '';

                const mcList = block.querySelector('.choices-list');
                (data.choices.length ? data.choices : ['', '', '', '']).forEach((c, i) => {
                    const item = createChoice(qIdx, i, c);
                    if (data.mc_correct == i) item.querySelector('input[type="radio"]').checked = true;
                    mcList.appendChild(item);
                });

                if (data.tf === 'true') block.querySelector('input[value="true"]').checked = true;
                if (data.tf === 'false') block.querySelector('input[value="false"]').checked = true;

                // Sync UI
                block.querySelector('.mc-box').classList.toggle('hidden', data.type !== 'multiple_choice');
                block.querySelector('.tf-box').classList.toggle('hidden', data.type !== 'true_false');
                block.querySelector('.blank-box').classList.toggle('hidden', data.type !== 'fill_blank');
            } else {
                // Default 4 choices
                const mcList = block.querySelector('.choices-list');
                for(let i=0; i<4; i++) mcList.appendChild(createChoice(qIdx, i));
            }

            container.appendChild(block);
            showQuestion(document.querySelectorAll('.question-block').length - 1);
        }

        // Global Event Listeners
        container.addEventListener('click', e => {
            if (e.target.closest('.del-q-btn')) {
                const blocks = document.querySelectorAll('.question-block');
                if (blocks.length > 1) {
                    e.target.closest('.question-block').remove();
                    showQuestion(0);
                    saveToLocal();
                } else {
                    showModal('Warning', 'You must have at least one question.');
                }
            }
            if (e.target.closest('.add-choice-btn')) {
                const block = e.target.closest('.question-block');
                const qIdx = block.getAttribute('data-idx');
                const list = block.querySelector('.choices-list');
                list.appendChild(createChoice(qIdx, list.children.length));
                saveToLocal();
            }
            if (e.target.closest('.del-choice')) {
                const list = e.target.closest('.choices-list');
                if (list.children.length > 2) {
                    e.target.closest('.choice-item').remove();
                    // Re-index
                    const qIdx = e.target.closest('.question-block').getAttribute('data-idx');
                    list.querySelectorAll('.choice-item').forEach((item, i) => {
                        item.querySelector('input[type="radio"]').value = i;
                        const textInput = item.querySelector('input[type="text"]');
                        textInput.name = `questions[${qIdx}][choices][${i}][choice_text]`;
                        textInput.placeholder = `Choice ${String.fromCharCode(65 + i)}`;
                    });
                    saveToLocal();
                }
            }
        });

        container.addEventListener('change', e => {
            if (e.target.classList.contains('q-type-select')) {
                const block = e.target.closest('.question-block');
                const val = e.target.value;
                block.querySelector('.mc-box').classList.toggle('hidden', val !== 'multiple_choice');
                block.querySelector('.tf-box').classList.toggle('hidden', val !== 'true_false');
                block.querySelector('.blank-box').classList.toggle('hidden', val !== 'fill_blank');
            }
            saveToLocal();
        });

        container.addEventListener('input', saveToLocal);

        document.getElementById('prev-question-btn').onclick = () => showQuestion(activeIdx - 1);
        document.getElementById('next-question-btn').onclick = () => showQuestion(activeIdx + 1);

        document.getElementById('add-question-btn').onclick = () => {
            addQuestion();
            saveToLocal();
        };

        // Modal Helper
        function showModal(title, content) {
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-content').innerHTML = content;
            document.getElementById('custom-modal').classList.remove('hidden');
        }
        document.getElementById('modal-close-btn').onclick = () => document.getElementById('custom-modal').classList.add('hidden');

        // Form Validation before submit
        document.getElementById('exam-form').onsubmit = function(e) {
            const blocks = document.querySelectorAll('.question-block');
            let errors = [];

            blocks.forEach((b, i) => {
                const num = i + 1;
                const type = b.querySelector('.q-type-select').value;
                if (!b.querySelector('textarea').value.trim()) errors.push(`Question ${num}: Content is missing.`);

                if (type === 'multiple_choice') {
                    let hasChecked = b.querySelector('.correct-choice-radio:checked');
                    if (!hasChecked) errors.push(`Question ${num}: Select a correct choice.`);
                    b.querySelectorAll('.choice-item input[type="text"]').forEach((input, ci) => {
                        if (!input.value.trim()) errors.push(`Question ${num}: Choice ${String.fromCharCode(65+ci)} is empty.`);
                    });
                } else if (type === 'true_false') {
                    if (!b.querySelector('input[name*="correct_answer_tf"]:checked')) errors.push(`Question ${num}: Select True or False.`);
                } else if (type === 'fill_blank') {
                    if (!b.querySelector('.blank-box input').value.trim()) errors.push(`Question ${num}: Provide the correct answer text.`);
                }
            });

            if (errors.length > 0) {
                e.preventDefault();
                showModal('Validation Errors', `<ul class="list-disc list-inside">${errors.map(err => `<li>${err}</li>`).join('')}</ul>`);
                return false;
            }

            localStorage.removeItem(STORAGE_KEY);
            return true;
        };

        // Initialization
        const saved = localStorage.getItem(STORAGE_KEY);
        if (saved) {
            const state = JSON.parse(saved);
            state.questions.forEach(q => addQuestion(q));
            activeIdx = state.activeIdx || 0;
            showQuestion(activeIdx);
        } else {
            addQuestion();
        }
    </script>
</x-app-layout>
