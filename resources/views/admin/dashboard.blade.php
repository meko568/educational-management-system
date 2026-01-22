<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin Dashboard') }} 
                @if(isset($academicYear))
                    <span class="text-sm font-normal text-gray-600 dark:text-gray-400">- {{ $academicYear }}</span>
                @endif
            </h2>
            
            <!-- Academic Year Dropdown -->
            <div class="relative">
                <select onchange="window.location.href = this.value" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Select Academic Year --</option>
                    <option value="{{ route('admin.dashboard.year', ['academicYear' => 'primary1']) }}" @if((isset($academicYear) && $academicYear === 'primary1')) selected @endif>Primary 1</option>
                    <option value="{{ route('admin.dashboard.year', ['academicYear' => 'primary2']) }}" @if((isset($academicYear) && $academicYear === 'primary2')) selected @endif>Primary 2</option>
                    <option value="{{ route('admin.dashboard.year', ['academicYear' => 'primary3']) }}" @if((isset($academicYear) && $academicYear === 'primary3')) selected @endif>Primary 3</option>
                    <option value="{{ route('admin.dashboard.year', ['academicYear' => 'primary4']) }}" @if((isset($academicYear) && $academicYear === 'primary4')) selected @endif>Primary 4</option>
                    <option value="{{ route('admin.dashboard.year', ['academicYear' => 'primary5']) }}" @if((isset($academicYear) && $academicYear === 'primary5')) selected @endif>Primary 5</option>
                    <option value="{{ route('admin.dashboard.year', ['academicYear' => 'primary6']) }}" @if((isset($academicYear) && $academicYear === 'primary6')) selected @endif>Primary 6</option>
                    <option value="{{ route('admin.dashboard.year', ['academicYear' => 'prep1']) }}" @if((isset($academicYear) && $academicYear === 'prep1')) selected @endif>Prep 1</option>
                    <option value="{{ route('admin.dashboard.year', ['academicYear' => 'prep2']) }}" @if((isset($academicYear) && $academicYear === 'prep2')) selected @endif>Prep 2</option>
                    <option value="{{ route('admin.dashboard.year', ['academicYear' => 'prep3']) }}" @if((isset($academicYear) && $academicYear === 'prep3')) selected @endif>Prep 3</option>
                    <option value="{{ route('admin.dashboard.year', ['academicYear' => 'sec1']) }}" @if((isset($academicYear) && $academicYear === 'sec1')) selected @endif>Secondary 1</option>
                    <option value="{{ route('admin.dashboard.year', ['academicYear' => 'sec2']) }}" @if((isset($academicYear) && $academicYear === 'sec2')) selected @endif>Secondary 2</option>
                    <option value="{{ route('admin.dashboard.year', ['academicYear' => 'sec3']) }}" @if((isset($academicYear) && $academicYear === 'sec3')) selected @endif>Secondary 3</option>
                </select>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Students Management Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Students
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            Manage Students
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('admin.students.index', ['academicYear' => isset($academicYear) ? $academicYear : 'primary1']) }}" 
                               class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                View all students
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Attendance Management Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Attendance
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            Manage Attendance
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('admin.attendances.index', ['academicYear' => isset($academicYear) ? $academicYear : 'primary1']) }}" 
                               class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                                View attendance
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Exams Management Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Exams
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            Manage & Record
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('admin.exams.index', ['academicYear' => isset($academicYear) ? $academicYear : 'primary1']) }}" 
                               class="inline-flex items-center text-sm font-medium text-purple-600 hover:text-purple-500 dark:text-purple-400 dark:hover:text-purple-300">
                                Go to Exams
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Exam Results Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Quizzes
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            Manage & Record
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('admin.quizzes.index', ['academicYear' => isset($academicYear) ? $academicYear : 'primary1']) }}"
                               class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                Go to Quizzes
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Courses Management Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-orange-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Courses
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            Manage & Lessons
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('admin.courses.index', ['academicYear' => isset($academicYear) ? $academicYear : 'primary1']) }}" 
                               class="inline-flex items-center text-sm font-medium text-orange-600 hover:text-orange-500 dark:text-orange-400 dark:hover:text-orange-300">
                                Go to Courses
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Add New Student Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Quick Action
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            Add New Student
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('admin.students.create', ['academicYear' => isset($academicYear) ? $academicYear : 'primary1']) }}" 
                               class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-500 dark:text-green-400 dark:hover:text-green-300">
                                Create student
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Parents Management Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-teal-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1m-4 6H2v-2a4 4 0 014-4h2m4 6v-2a4 4 0 00-4-4H7m4-6a4 4 0 012-4h2a4 4 0 012 4m-2 6h-2a4 4 0 01-4 4v2a4 4 0 01-4-4H7m4-6a4 4 0 012-4h2a4 4 0 012 4m-2 6H7m4-6a4 4 0 012-4h2a4 4 0 012 4m-2 6H7" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Parents
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            Codes & Sons
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('admin.parents.index') }}"
                               class="inline-flex items-center text-sm font-medium text-teal-600 hover:text-teal-500 dark:text-teal-400 dark:hover:text-teal-300">
                                Go to Parents
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Student Performance Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Top Performing Students</h3>
                        @if(empty($chartData['studentPerformance']['data']))
                        <div class="chart-container flex items-center justify-center" style="position: relative; height:300px;">
                            <p class="text-gray-500 dark:text-gray-400">No exam data available</p>
                        </div>
                        @else
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="studentPerformanceChart"></canvas>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Exam Statistics Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Exam Statistics</h3>
                        @if(empty($chartData['examStats']['avgScores']))
                        <div class="chart-container flex items-center justify-center" style="position: relative; height:300px;">
                            <p class="text-gray-500 dark:text-gray-400">No exam data available</p>
                        </div>
                        @else
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="examStatsChart"></canvas>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quiz Statistics Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Quiz Statistics</h3>
                        @if(empty($chartData['quizStats']['avgScores']))
                        <div class="chart-container flex items-center justify-center" style="position: relative; height:300px;">
                            <p class="text-gray-500 dark:text-gray-400">No quiz data available</p>
                        </div>
                        @else
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="quizStatsChart"></canvas>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Attendance Overview Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Attendance Overview</h3>
                        @if(empty($chartData['attendance']['total']) || $chartData['attendance']['total'] == 0)
                        <div class="chart-container flex items-center justify-center" style="position: relative; height:300px;">
                            <p class="text-gray-500 dark:text-gray-400">No attendance data available</p>
                        </div>
                        @else
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Student Performance Chart
            @if(!empty($chartData['studentPerformance']['data']) && count($chartData['studentPerformance']['data']) > 0)
            try {
                const studentCtx = document.getElementById('studentPerformanceChart').getContext('2d');
                new Chart(studentCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($chartData['studentPerformance']['labels']),
                        datasets: [{
                            label: '{{ $chartData["studentPerformance"]["label"] }}',
                            data: @json($chartData['studentPerformance']['data']),
                            backgroundColor: @json($chartData['studentPerformance']['backgroundColors']),
                            borderColor: '{{ $chartData["studentPerformance"]["borderColor"] }}',
                            borderWidth: 2,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.raw + '%';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                title: { display: true, text: 'Score (%)' },
                                ticks: {
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                }
                            },
                            x: {
                                title: { display: true, text: 'Students' }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error initializing student performance chart:', error);
            }
            @endif

            // Initialize Exam Statistics Chart
            @if(!empty($chartData['examStats']['avgScores']) && count($chartData['examStats']['avgScores']) > 0)
            try {
                const examCtx = document.getElementById('examStatsChart').getContext('2d');
                new Chart(examCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($chartData['examStats']['labels']),
                        datasets: [
                            {
                                label: 'Average Score',
                                data: @json($chartData['examStats']['avgScores']),
                                backgroundColor: 'rgba(16, 185, 129, 0.5)',
                                borderColor: '{{ $chartData["examStats"]["avgScoreColor"] }}',
                                borderWidth: 2,
                                type: 'line',
                                tension: 0.3,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '{{ $chartData["examStats"]["avgScoreColor"] }}',
                                pointHoverBackgroundColor: '{{ $chartData["examStats"]["avgScoreColor"] }}',
                                pointHoverBorderColor: '#fff',
                                fill: false,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Total Attempts',
                                data: @json($chartData['examStats']['totalAttempts']),
                                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                                borderColor: '{{ $chartData["examStats"]["attemptsColor"] }}',
                                borderWidth: 2,
                                borderRadius: 4,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Score (%)' },
                                grid: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                                },
                                ticks: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151',
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                }
                            },
                            y1: {
                                beginAtZero: true,
                                position: 'right',
                                title: { display: true, text: 'Attempts' },
                                grid: {
                                    drawOnChartArea: false
                                },
                                ticks: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                                }
                            },
                            x: {
                                title: { display: true, text: 'Exams' },
                                grid: { display: false },
                                ticks: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.dataset.label || '';
                                        const value = context.raw || 0;
                                        const suffix = context.dataset.label === 'Average Score' ? '%' : '';
                                        return `${label}: ${value}${suffix}`;
                                    }
                                }
                            },
                            legend: {
                                position: 'top',
                                labels: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error initializing exam statistics chart:', error);
            }
            @endif

            // Initialize Quiz Statistics Chart
            @if(!empty($chartData['quizStats']['avgScores']) && count($chartData['quizStats']['avgScores']) > 0)
            try {
                const quizCtx = document.getElementById('quizStatsChart').getContext('2d');
                new Chart(quizCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($chartData['quizStats']['labels']),
                        datasets: [
                            {
                                label: 'Average Score',
                                data: @json($chartData['quizStats']['avgScores']),
                                backgroundColor: 'rgba(245, 158, 11, 0.5)',
                                borderColor: '{{ $chartData["quizStats"]["avgScoreColor"] }}',
                                borderWidth: 2,
                                type: 'line',
                                tension: 0.3,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '{{ $chartData["quizStats"]["avgScoreColor"] }}',
                                pointHoverBackgroundColor: '{{ $chartData["quizStats"]["avgScoreColor"] }}',
                                pointHoverBorderColor: '#fff',
                                fill: false,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Total Attempts',
                                data: @json($chartData['quizStats']['totalAttempts']),
                                backgroundColor: 'rgba(139, 92, 246, 0.5)',
                                borderColor: '{{ $chartData["quizStats"]["attemptsColor"] }}',
                                borderWidth: 2,
                                borderRadius: 4,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Score / Attempts' },
                                grid: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                                },
                                ticks: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151',
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                }
                            },
                            y1: {
                                beginAtZero: true,
                                position: 'right',
                                title: { display: true, text: 'Attempts' },
                                grid: {
                                    drawOnChartArea: false
                                },
                                ticks: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                                }
                            },
                            x: {
                                title: { display: true, text: 'Quizzes' },
                                grid: { display: false },
                                ticks: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.dataset.label || '';
                                        const value = context.raw || 0;
                                        const suffix = context.dataset.label === 'Average Score' ? '%' : '';
                                        return `${label}: ${value}${suffix}`;
                                    }
                                }
                            },
                            legend: {
                                position: 'top',
                                labels: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151'
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error initializing quiz statistics chart:', error);
            }
            @endif
            @if(!empty($chartData['attendance']['total']) && $chartData['attendance']['total'] > 0)
            try {
                const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
                new Chart(attendanceCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($chartData['attendance']['labels']),
                        datasets: [{
                            data: @json([
                                $chartData['attendance']['present'],
                                $chartData['attendance']['absent']
                            ]),
                            backgroundColor: @json($chartData['attendance']['backgroundColors']),
                            borderWidth: 1,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#374151',
                                    padding: 20,
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error initializing attendance chart:', error);
            }
            @endif
        });
    </script>
</x-app-layout>