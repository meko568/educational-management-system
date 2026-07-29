<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Student Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('messages.student_dashboard_title') }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem;">{{ __('messages.welcome_back') }}, {{ $student->name }}. {{ __('messages.track_progress') }}</p>
            </div>

            <div style="display: flex; align-items: center; gap: 1rem; background-color: var(--bg-card); padding: 0.75rem 1.5rem; border-radius: 1.25rem; border: 1px solid var(--border-color); box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                <div style="text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">
                    <p style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ __('messages.attendance') }}</p>
                    <p style="font-size: 1.25rem; font-weight: 900; color: #10b981; margin: 0.25rem 0 0 0;">{{ $attendance['percentage'] }}%</p>
                </div>
                <div style="height: 2rem; width: 1px; background-color: var(--border-color);"></div>
                <div style="text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};">
                    <p style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ __('messages.status') }}</p>
                    <span style="display: inline-flex; align-items: center; gap: 0.375rem; font-size: 0.875rem; font-weight: 700; color: #4f46e5; margin-top: 0.25rem;">
                        <span style="width: 0.5rem; height: 0.5rem; border-radius: 9999px; background-color: #4f46e5;"></span> {{ __('messages.active') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Available Assessments -->
        @if($availableQuizzes->count() > 0 || $availableExams->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin: 0;">Pending Assessments</h2>
                <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;" class="md:grid-cols-2 lg:grid-cols-3">
                    @foreach($availableExams as $exam)
                        <div class="card-custom" style="border-left: 4px solid #4f46e5; display: flex; flex-direction: column; gap: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                <span style="padding: 0.25rem 0.5rem; background-color: rgba(79, 70, 229, 0.1); color: #4f46e5; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase;">Exam</span>
                                <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">{{ $exam->duration_minutes }} mins</span>
                            </div>
                            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ $exam->title }}</h3>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.8125rem; color: var(--text-muted);">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    <span>Ends: {{ $exam->end_datetime->format('M d, H:i') }}</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                    <span>{{ $exam->questions_count }} Questions</span>
                                </div>
                            </div>
                            <form action="{{ route('student.exams.start', $exam->id) }}" method="POST" style="margin-top: auto;">
                                @csrf
                                <button type="submit" style="width: 100%; padding: 0.75rem; background-color: #4f46e5; color: white; border: none; border-radius: 0.75rem; font-weight: 700; font-size: 0.875rem; cursor: pointer; transition: opacity 0.2s;">
                                    Start Exam
                                </button>
                            </form>
                        </div>
                    @endforeach

                    @foreach($availableQuizzes as $quiz)
                        <div class="card-custom" style="border-left: 4px solid #10b981; display: flex; flex-direction: column; gap: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                <span style="padding: 0.25rem 0.5rem; background-color: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase;">Quiz</span>
                                <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">{{ $quiz->duration_minutes }} mins</span>
                            </div>
                            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ $quiz->title }}</h3>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.8125rem; color: var(--text-muted);">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    <span>Ends: {{ $quiz->end_datetime->format('M d, H:i') }}</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                    <span>{{ $quiz->questions_count }} Questions</span>
                                </div>
                            </div>
                            <form action="{{ route('student.quizzes.start', $quiz->id) }}" method="POST" style="margin-top: auto;">
                                @csrf
                                <button type="submit" style="width: 100%; padding: 0.75rem; background-color: #10b981; color: white; border: none; border-radius: 0.75rem; font-weight: 700; font-size: 0.875rem; cursor: pointer; transition: opacity 0.2s;">
                                    Start Quiz
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Charts Grid (Analytics) -->
        <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;" class="lg:grid-cols-2">
            <!-- Manual Exams Performance -->
            <div class="card-custom">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem;">{{ __('messages.manual_exams_performance') }}</h2>
                <div style="height: 320px; width: 100%;">
                    <canvas id="manualExamsChart"></canvas>
                </div>
            </div>

            <!-- Auto-Revision Exams Performance -->
            <div class="card-custom">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem;">{{ __('messages.auto_exams_performance') }}</h2>
                <div style="height: 320px; width: 100%;">
                    <canvas id="autoExamsChart"></canvas>
                </div>
            </div>

            <!-- Manual Quizzes Performance -->
            <div class="card-custom">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem;">{{ __('messages.manual_quizzes_performance') }}</h2>
                <div style="height: 320px; width: 100%;">
                    <canvas id="manualQuizzesChart"></canvas>
                </div>
            </div>

            <!-- Auto-Revision Quizzes Performance -->
            <div class="card-custom">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem;">{{ __('messages.auto_quizzes_performance') }}</h2>
                <div style="height: 320px; width: 100%;">
                    <canvas id="autoQuizzesChart"></canvas>
                </div>
            </div>

            <!-- Attendance Overview Chart -->
            <div class="card-custom lg:col-span-2">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem; text-align: center;">{{ __('messages.attendance_summary') }}</h2>
                <div style="height: 320px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <div style="width: 100%; max-width: 256px; height: 256px;">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                    <div style="margin-top: 1rem; display: flex; gap: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="width: 0.75rem; height: 0.75rem; border-radius: 9999px; background-color: #10b981;"></span>
                            <span style="font-size: 0.875rem; font-weight: 700; color: var(--text-muted);">{{ $attendance['present'] }} {{ __('messages.present') }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="width: 0.75rem; height: 0.75rem; border-radius: 9999px; background-color: #f87171;"></span>
                            <span style="font-size: 0.875rem; font-weight: 700; color: var(--text-muted);">{{ $attendance['absent'] }} {{ __('messages.absent') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Table -->
        <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;" class="lg:grid-cols-3">

            <!-- My Courses Section -->
            <div class="lg:col-span-1" style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('messages.courses') }}</h2>
                    <a href="{{ route('student.courses.index') }}" style="font-size: 0.75rem; font-weight: 800; color: #4f46e5; text-decoration: none; text-transform: uppercase;">{{ __('messages.view_all') }} →</a>
                </div>

                @if($courses->isEmpty())
                    <div class="card-custom" style="padding: 2rem; text-align: center; border-style: dashed;">
                        <p style="color: var(--text-muted); font-size: 0.875rem; margin: 0;">No courses assigned for this year yet.</p>
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        @foreach($courses->take(4) as $course)
                            <a href="{{ route('student.courses.show', $course) }}" style="text-decoration: none;" class="card-custom">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 2.5rem; height: 2.5rem; background-color: rgba(79, 70, 229, 0.1); color: #4f46e5; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <h4 style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $course->name }}</h4>
                                        <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0.125rem 0 0 0;">{{ $course->lessons_count }} {{ __('messages.lessons') }}</p>
                                    </div>
                                    <svg style="width: 1rem; height: 1rem; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                <!-- My Quizzes Section -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 1rem;">
                    <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('messages.my_quizzes') }}</h2>
                    <a href="{{ route('student.quizzes.index') }}" style="font-size: 0.75rem; font-weight: 800; color: #10b981; text-decoration: none; text-transform: uppercase;">{{ __('messages.view_all') }} →</a>
                </div>
                <a href="{{ route('student.quizzes.index') }}" style="text-decoration: none;" class="card-custom">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 2.5rem; height: 2.5rem; background-color: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h4 style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('messages.quizzes') }}</h4>
                            <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0.125rem 0 0 0;">View your active and past quizzes</p>
                        </div>
                        <svg style="width: 1rem; height: 1rem; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </div>
                </a>

                <!-- My Exams Section -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 1rem;">
                    <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('messages.my_exams') }}</h2>
                    <a href="{{ route('student.exams.index') }}" style="font-size: 0.75rem; font-weight: 800; color: #4f46e5; text-decoration: none; text-transform: uppercase;">{{ __('messages.view_all') }} →</a>
                </div>
                <a href="{{ route('student.exams.index') }}" style="text-decoration: none;" class="card-custom">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 2.5rem; height: 2.5rem; background-color: rgba(79, 70, 229, 0.1); color: #4f46e5; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h4 style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('messages.exams') }}</h4>
                            <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0.125rem 0 0 0;">View your scheduled and completed exams</p>
                        </div>
                        <svg style="width: 1rem; height: 1rem; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </div>
                </a>
            </div>

            <!-- Results Table -->
            <div class="lg:col-span-2" style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div class="card-custom" style="padding: 0; overflow: hidden;">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('messages.academic_results') }}</h2>
                <p style="font-size: 0.875rem; color: var(--text-muted); margin-top: 0.25rem;">{{ __('messages.unified_view') }}</p>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}; border-collapse: collapse; font-size: 0.875rem;">
                    <thead style="background-color: var(--bg-alt);">
                        <tr>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">{{ __('messages.assessment_title') }}</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">{{ __('messages.category') }}</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: center;">{{ __('messages.score') }}</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">{{ __('messages.date') }}</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: var(--bg-card);">
                        @foreach($exams->concat($quizzes)->sortByDesc('date') as $item)
                            <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.2s;">
                                <td style="padding: 1rem 1.5rem; font-weight: 500; color: var(--text-main);">{{ $item['title'] }}</td>
                                <td style="padding: 1rem 1.5rem;">
                                    <span style="padding: 0.25rem 0.625rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700; {{ $item['type'] === 'Auto-Revision' ? 'background-color: rgba(168, 85, 247, 0.1); color: #a855f7;' : 'background-color: rgba(245, 158, 11, 0.1); color: #f59e0b;' }}">
                                        {{ $item['type'] }}
                                    </span>
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: center;">
                                    <span style="font-weight: 700; {{ $item['percentage'] >= 50 ? 'color: #10b981;' : 'color: #ef4444;' }}">
                                        {{ round($item['percentage']) }}%
                                    </span>
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}; color: var(--text-muted); font-weight: 500;">
                                    {{ $item['date'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark');
            Chart.defaults.font.family = "'Inter', sans-serif";
            Chart.defaults.color = isDark ? "#94a3b8" : "#64748b";

            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 110,
                        grid: { color: isDark ? '#1e293b' : '#f1f5f9' },
                        ticks: {
                            callback: function(value) { return value <= 100 ? value + '%' : ''; }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: isDark ? '#f8fafc' : '#0f172a', font: { weight: 'bold' } }
                    }
                }
            };

            // Manual Exams Chart
            new Chart(document.getElementById('manualExamsChart'), {
                type: 'line',
                data: {
                    labels: @json($chartData['manualExam']['labels']),
                    datasets: [{
                        label: 'Manual Exam Scores (%)',
                        data: @json($chartData['manualExam']['data']),
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: commonOptions
            });

            // Auto Exams Chart
            new Chart(document.getElementById('autoExamsChart'), {
                type: 'line',
                data: {
                    labels: @json($chartData['autoExam']['labels']),
                    datasets: [{
                        label: 'Auto Exam Scores (%)',
                        data: @json($chartData['autoExam']['data']),
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: commonOptions
            });

            // Manual Quizzes Chart
            new Chart(document.getElementById('manualQuizzesChart'), {
                type: 'line',
                data: {
                    labels: @json($chartData['manualQuiz']['labels']),
                    datasets: [{
                        label: 'Manual Quiz Scores (%)',
                        data: @json($chartData['manualQuiz']['data']),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: commonOptions
            });

            // Auto Quizzes Chart
            new Chart(document.getElementById('autoQuizzesChart'), {
                type: 'line',
                data: {
                    labels: @json($chartData['autoQuiz']['labels']),
                    datasets: [{
                        label: 'Auto Quiz Scores (%)',
                        data: @json($chartData['autoQuiz']['data']),
                        borderColor: '#34d399',
                        backgroundColor: 'rgba(52, 211, 153, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: commonOptions
            });

            // Attendance Doughnut
            new Chart(document.getElementById('attendanceChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($chartData['attendance']['labels']),
                    datasets: [{
                        data: @json($chartData['attendance']['data']),
                        backgroundColor: ['#10b981', '#f87171'],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '80%',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
