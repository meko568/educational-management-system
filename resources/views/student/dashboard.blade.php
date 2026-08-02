<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-stone-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Exam Performance Chart -->
                <div class="bg-white dark:bg-stone-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-stone-900 dark:text-stone-100 mb-4">Exam Performance</h3>
                        <div class="chart-container" style="position: relative; height:400px;">
                            <canvas id="examChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Quiz Performance Chart -->
                <div class="bg-white dark:bg-stone-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-stone-900 dark:text-stone-100 mb-4">Quiz Performance</h3>
                        <div class="chart-container" style="position: relative; height:400px;">
                            <canvas id="quizChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Attendance Overview Chart -->
                <div class="bg-white dark:bg-stone-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-stone-900 dark:text-stone-100 mb-4">Attendance Overview</h3>
                        <div class="chart-container" style="position: relative; height:400px;">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-stone-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-stone-900">Welcome, {{ $student->name }}</h3>
                            <p class="text-stone-600">Student Code: {{ $student->code }}</p>
                            <p class="text-stone-600">Academic Year: {{ $student->academicYear ?? 'N/A' }}</p>
                            @if($student->phone)
                                <p class="text-stone-600">Phone: {{ $student->phone }}</p>
                            @endif
                            @if($student->parent_phone)
                                <p class="text-stone-600">Parent's Phone: {{ $student->parent_phone }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-orange-600">
                                {{ $attendance['attendance_percentage'] }}%
                            </div>
                            <div class="text-sm text-stone-500">Attendance</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-6 mb-6">
                <!-- Exams Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-stone-900">Exams</h3>
                                <p class="text-2xl font-semibold text-stone-700">{{ count($examResults) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quizzes Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-stone-900">Quizzes</h3>
                                <p class="text-2xl font-semibold text-stone-700">{{ count($quizResults) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-stone-900">Attendance</h3>
                                <p class="text-2xl font-semibold text-stone-700">{{ $attendance['present'] }}/{{ $attendance['total'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Courses Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-stone-900">Courses</h3>
                                    <p class="text-2xl font-semibold text-stone-700">Manage Lessons</p>
                                </div>
                            </div>
                            <a href="{{ route('student.courses.index') }}" class="inline-flex items-center px-3 py-1 bg-orange-100 text-orange-600 rounded hover:bg-orange-200 font-medium text-sm">
                                View →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Available Exams Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-pink-100 text-pink-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-stone-900">Auto-Revision Exams</h3>
                                    <p class="text-2xl font-semibold text-stone-700">Take Exams</p>
                                </div>
                            </div>
                            <a href="{{ route('student.exams.index') }}" class="inline-flex items-center px-3 py-1 bg-pink-100 text-pink-600 rounded hover:bg-pink-200 font-medium text-sm">
                                View →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Available Quizzes Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-orange-100 to-orange-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-stone-900">Auto-Revision Quizzes</h3>
                                    <p class="text-2xl font-semibold text-stone-700">Take Quizzes</p>
                                </div>
                            </div>
                            <a href="{{ route('student.quizzes.index') }}" class="inline-flex items-center px-3 py-1 bg-orange-100 text-orange-600 rounded hover:bg-orange-200 font-medium text-sm">
                                View →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Results Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Recent Exams -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-stone-900 mb-4">Recent Exam Results</h3>
                        @if(count($examResults) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-stone-200">
                                    <thead class="bg-stone-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Exam</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Score</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-stone-200">
                                        @foreach($examResults->take(5) as $exam)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-stone-900">{{ $exam['exam'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-500">{{ $exam['date'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $exam['percentage'] >= 50 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $exam['marks_obtained'] }}/{{ $exam['total_marks'] }} ({{ round($exam['percentage']) }}%)
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-stone-500">No exam results available.</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Attendance -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-stone-900 mb-4">Recent Attendance</h3>
                        @if(count($attendance['recent']) > 0)
                            <div class="space-y-4">
                                @foreach($attendance['recent'] as $record)
                                    <div class="flex items-center justify-between p-3 rounded-lg {{ $record['status'] === 'present' ? 'bg-green-50' : 'bg-red-50' }}">
                                        <div>
                                            <p class="text-sm font-medium text-stone-900">{{ $record['date'] }}</p>
                                            <p class="text-sm text-stone-500">{{ $record['subject'] }}</p>
                                        </div>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $record['status'] === 'present' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($record['status']) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-stone-500">No attendance records available.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- All Results Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-stone-900 mb-4">All Quiz Results</h3>
                    @if(count($quizResults) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-stone-200">
                                <thead class="bg-stone-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Quiz</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Score</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-stone-200">
                                    @foreach($quizResults as $quiz)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-stone-900">{{ $quiz['quiz'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-500">{{ $quiz['date'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $quiz['percentage'] >= 50 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $quiz['marks_obtained'] }}/{{ $quiz['total_marks'] }} ({{ round($quiz['percentage']) }}%)
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-stone-500">No quiz results available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Helper function to create a chart
            function createChart(elementId, type, chartData, options = {}) {
                const ctx = document.getElementById(elementId);
                if (!ctx) return;

                const defaultOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    if (type === 'doughnut') {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                    return `${label}: ${value}%`;
                                }
                            }
                        }
                    },
                    scales: {}
                };

                if (type === 'bar' || type === 'line') {
                    defaultOptions.scales = {
                        y: {
                            beginAtZero: true,
                            max: 110,
                            ticks: {
                                stepSize: 20,
                                callback: function(value) {
                                    if (value > 100) return '';
                                    return value + '%';
                                },
                                color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                            },
                            grid: {
                                color: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                            },
                            grid: {
                                display: false
                            }
                        }
                    };
                }

                // Prepare dataset with proper fill settings
                const dataset = {
                    label: chartData.label || '',
                    data: chartData.data || [],
                    borderColor: chartData.borderColor || '#b5501f',
                    borderWidth: 2,
                    fill: false, // Explicitly disable fill for all chart types
                    pointBackgroundColor: chartData.pointBackgroundColor || chartData.borderColor || '#b5501f',
                    pointBorderColor: chartData.pointBorderColor || '#fff',
                    pointHoverBackgroundColor: chartData.pointHoverBackgroundColor || '#fff',
                    pointHoverBorderColor: chartData.pointHoverBorderColor || (chartData.borderColor || '#b5501f'),
                    pointRadius: chartData.pointRadius || 4,
                    pointHoverRadius: chartData.pointHoverRadius || 6,
                    borderDash: chartData.borderDash || [],
                    tension: chartData.tension || 0.3
                };

                // Only set backgroundColor for non-line charts
                if (type !== 'line') {
                    dataset.backgroundColor = chartData.backgroundColors || '#b5501f';
                }

                return new Chart(ctx.getContext('2d'), {
                    type: type,
                    data: {
                        labels: chartData.labels || [],
                        datasets: [dataset]
                    },
                    options: { ...defaultOptions, ...options }
                });
            }

            // Initialize exam chart
            @if(isset($chartData['exam']) && count($chartData['exam']['data']) > 0)
            createChart('examChart', 'line', {
                ...@json($chartData['exam']),
                label: 'Score (%)',
                borderColor: '#b5501f',
                backgroundColor: 'transparent',
                pointBackgroundColor: '#b5501f',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#b5501f',
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 2,
                tension: 0.3
            }, {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                elements: {
                    line: {
                        fill: false
                    }
                }
            });
            @endif

            // Initialize quiz chart
            @if(isset($chartData['quiz']) && count($chartData['quiz']['data']) > 0)
            createChart('quizChart', 'line', {
                ...@json($chartData['quiz']),
                label: 'Score (%)',
                borderColor: '#10b981',
                backgroundColor: 'transparent',
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#10b981',
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 2,
                borderDash: [],
                tension: 0.3,
                fill: false  // Explicitly set fill to false in the dataset
            }, {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                elements: {
                    line: {
                        fill: false
                    }
                }
            });
            @endif

            // Initialize attendance chart
            @if(isset($chartData['attendance']) && $attendance['total'] > 0)
            createChart('attendanceChart', 'doughnut', @json($chartData['attendance']));
            @endif
        });
    </script>
</x-app-layout>
