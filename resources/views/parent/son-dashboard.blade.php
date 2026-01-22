<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Son Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600">{{ $student->name }} ({{ $student->code }}) - {{ $academicYear }}</p>
            </div>
            <a href="{{ route('parent.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Exam Performance</h3>
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="examChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Quiz Performance</h3>
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="quizChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Attendance Overview</h3>
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $student->name }}</h3>
                            <p class="text-gray-600">Student Code: {{ $student->code }}</p>
                            <p class="text-gray-600">Academic Year: {{ $academicYear ?? 'N/A' }}</p>
                            @if($student->phone)
                                <p class="text-gray-600">Phone: {{ $student->phone }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-indigo-600">
                                {{ $attendance['attendance_percentage'] }}%
                            </div>
                            <div class="text-sm text-gray-500">Attendance</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Exam Results</h3>
                        @if(count($examResults) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($examResults->take(5) as $exam)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $exam['exam'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $exam['date'] }}</td>
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
                            <p class="text-gray-500">No exam results available.</p>
                        @endif
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Attendance (full date & time)</h3>
                        @if(count($attendance['recent']) > 0)
                            <div class="space-y-4">
                                @foreach($attendance['recent'] as $record)
                                    <div class="flex items-center justify-between p-3 rounded-lg {{ $record['status'] === 'present' ? 'bg-green-50' : 'bg-red-50' }}">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $record['date_time'] }}</p>
                                            @if(!empty($record['notes']))
                                                <p class="text-sm text-gray-500">{{ $record['notes'] }}</p>
                                            @endif
                                        </div>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $record['status'] === 'present' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($record['status']) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No attendance records available.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">All Quiz Results</h3>
                    @if(count($quizResults) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quiz</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($quizResults as $quiz)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $quiz['quiz'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $quiz['date'] }}</td>
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
                        <p class="text-gray-500">No quiz results available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function createChart(elementId, type, chartData, options = {}) {
                const ctx = document.getElementById(elementId);
                if (!ctx) return;

                const defaultOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {}
                };

                if (type === 'bar' || type === 'line') {
                    defaultOptions.scales = {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        },
                        x: {
                            grid: { display: false }
                        }
                    };
                }

                const dataset = {
                    label: chartData.label || '',
                    data: chartData.data || [],
                    borderColor: chartData.borderColor || '#4f46e5',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.3
                };

                if (type !== 'line') {
                    dataset.backgroundColor = chartData.backgroundColors || '#4f46e5';
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

            @if(isset($chartData['exam']) && count($chartData['exam']['data']) > 0)
            createChart('examChart', 'line', {
                ...@json($chartData['exam']),
                label: 'Score (%)',
                borderColor: '#4f46e5'
            });
            @endif

            @if(isset($chartData['quiz']) && count($chartData['quiz']['data']) > 0)
            createChart('quizChart', 'line', {
                ...@json($chartData['quiz']),
                label: 'Score (%)',
                borderColor: '#10b981'
            });
            @endif

            @if(isset($chartData['attendance']) && $attendance['total'] > 0)
            createChart('attendanceChart', 'doughnut', @json($chartData['attendance']));
            @endif
        });
    </script>
</x-app-layout>
