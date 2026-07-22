<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $quiz->title }}
            </h2>
            <div class="flex space-x-2">
                @if($quiz->questions->count() > 0)
                    <a href="{{ route('admin.quizzes.questions.create', $quiz->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                        Add More Questions
                    </a>
                @else
                    <a href="{{ route('admin.quizzes.questions.create', $quiz->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        Add Questions
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Quiz Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Grade</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $quiz->grade }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Duration</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $quiz->duration_minutes }} minutes</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Start Time</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $quiz->start_datetime->format('M d, Y - H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">End Time</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $quiz->end_datetime->format('M d, Y - H:i') }}</p>
                        </div>
                    </div>
                    @if($quiz->description)
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $quiz->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Questions Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Questions ({{ $quiz->questions->count() }})
                    </h3>
                    
                    @if($quiz->questions->count() > 0)
                        <div class="space-y-6">
                            @foreach($quiz->questions as $index => $question)
                                <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                    <div class="flex items-start justify-between mb-3">
                                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">
                                            Question {{ $index + 1 }} ({{ $question->points }} points)
                                            <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                                {{ ucfirst(str_replace('_', ' ', $question->type)) }}
                                            </span>
                                        </h4>
                                    </div>
                                    
                                    <p class="text-gray-700 dark:text-gray-300 mb-3">{{ $question->question_text }}</p>
                                    
                                    @if($question->question_image)
                                        <img src="{{ $question->question_image }}" alt="Question Image" class="mb-3 max-w-md rounded-lg">
                                    @endif

                                    @if($question->type === 'multiple_choice' || $question->type === 'true_false')
                                        <div class="space-y-2">
                                            @foreach($question->choices as $choice)
                                                <div class="flex items-center p-2 rounded @if($choice->is_correct) bg-green-100 dark:bg-green-900 @else bg-gray-50 dark:bg-gray-700 @endif">
                                                    <span class="text-gray-700 dark:text-gray-300">
                                                        {{ $choice->choice_text }}
                                                        @if($choice->is_correct)
                                                            <span class="ml-2 text-green-600 dark:text-green-400 font-medium">✓ Correct</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($question->type === 'fill_blank')
                                        @php
                                            $correctAnswer = $question->choices->where('is_correct', true)->first();
                                        @endphp
                                        @if($correctAnswer)
                                            <div class="p-2 rounded bg-green-100 dark:bg-green-900">
                                                <span class="text-gray-700 dark:text-gray-300">
                                                    Correct Answer: {{ $correctAnswer->choice_text }}
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <p>No questions added yet.</p>
                            <a href="{{ route('admin.quizzes.questions.create', $quiz->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">Add questions now</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Attempts Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Student Attempts ({{ $quiz->attempts->count() }})
                    </h3>
                    
                    @if($quiz->attempts->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Student</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Points</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Started</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Submitted</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($quiz->attempts as $attempt)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $attempt->student->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $attempt->score ? number_format($attempt->score, 1) . '%' : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $attempt->earned_points ?? '-' }}/{{ $attempt->total_points }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $attempt->started_at->format('M d, Y - H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $attempt->submitted_at ? $attempt->submitted_at->format('M d, Y - H:i') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($attempt->status === 'submitted')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Completed
                                                    </span>
                                                @elseif($attempt->status === 'timed_out')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Timed Out
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        In Progress
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <p>No student attempts yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-between">
                <a href="{{ route('admin.quizzes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600">
                    Back to Quizzes
                </a>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.quizzes.edit', $quiz->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        Edit Quiz
                    </a>
                    <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this quiz? This will also delete all questions and attempts.')"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                            Delete Quiz
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
