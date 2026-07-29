<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Dashboard Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('messages.education_dashboard') }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">{{ __('messages.overview_for') }} {{ strtoupper($academicYear) }} {{ __('messages.academic_year_short') }}</p>
            </div>

            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <!-- Academic Year Selector -->
                <div style="position: relative;">
                    <div style="position: absolute; top: 0; bottom: 0; display: flex; align-items: center; pointer-events: none; color: #14b8a6; z-index: 10; {{ app()->getLocale() === 'ar' ? 'right: 1rem;' : 'left: 1rem;' }}">
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <select onchange="window.location.href = this.value"
                            style="appearance: none; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); padding: 0.625rem 2.5rem; border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; cursor: pointer; transition: all 0.2s; min-width: 160px; {{ app()->getLocale() === 'ar' ? 'padding-right: 3rem;' : 'padding-left: 3rem;' }}">
                        <option value="">{{ __('messages.switch_grade') }}</option>
                        @foreach(['primary1', 'primary2', 'primary3', 'primary4', 'primary5', 'primary6', 'prep1', 'prep2', 'prep3', 'sec1', 'sec2', 'sec3'] as $year)
                            <option value="{{ route('admin.dashboard.year', ['academicYear' => $year]) }}" @if((isset($academicYear) && $academicYear === $year)) selected @endif>
                                {{ strtoupper($year) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Stat Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
            @php
                $stats = [
                    ['label' => __('messages.students'), 'value' => $totalStudents, 'route' => 'admin.students.index', 'params' => ['academicYear' => $academicYear], 'color' => 'indigo', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                    ['label' => __('messages.manual_exams'), 'value' => $totalExams, 'route' => 'admin.manual-exams.index', 'params' => ['academicYear' => $academicYear], 'color' => 'amber', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    ['label' => __('messages.manual_quizzes'), 'value' => $totalQuizzes, 'route' => 'admin.manual-quizzes.index', 'params' => ['academicYear' => $academicYear], 'color' => 'orange', 'icon' => 'M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z'],
                    ['label' => __('messages.auto_exams'), 'value' => $totalAutoExams, 'route' => 'admin.exams.index', 'params' => [], 'color' => 'pink', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                    ['label' => __('messages.auto_quizzes'), 'value' => $totalAutoQuizzes, 'route' => 'admin.quizzes.index', 'params' => [], 'color' => 'teal', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.183.445l-1.676 1.189c-.643.456-1.191.135-1.191-.652V5c0-.787.548-1.108 1.191-.652l1.676 1.189a2 2 0 001.183.445l1.933-.092a6 6 0 013.86.517l.318.158a6 6 0 003.86.517l2.387-.477a2 2 0 011.022.547l.572.572z'],
                    ['label' => 'Schedules', 'value' => $totalSchedules, 'route' => 'admin.schedules.index', 'params' => [], 'color' => 'blue', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ];
@endphp

            @foreach($stats as $stat)
            <a href="{{ route($stat['route'], $stat['params']) }}" style="text-decoration: none;" class="card-custom">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                    <div style="padding: 0.75rem; border-radius: 1rem; background-color: var(--border-color); color: var(--accent-color);">
                        <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}" />
                        </svg>
                    </div>
                    <span style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">{{ __('messages.manage') }} →</span>
                </div>
                <h3 style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ $stat['label'] }}</h3>
                <p style="font-size: 1.875rem; font-weight: 900; color: var(--text-main); margin-top: 0.5rem; margin-bottom: 0;">{{ $stat['value'] ?? 0 }}</p>
            </a>
            @endforeach

            <!-- Attendance Special Card -->
            <a href="{{ route('admin.attendances.index', ['academicYear' => $academicYear]) }}" style="text-decoration: none;" class="card-custom">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                    <div style="padding: 0.75rem; border-radius: 1rem; background-color: var(--border-color); color: #3b82f6;">
                        <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <span style="font-size: 0.75rem; font-weight: 800; color: #10b981; background-color: rgba(16, 185, 129, 0.1); padding: 0.25rem 0.5rem; border-radius: 0.5rem; text-transform: uppercase;">{{ $chartData['attendance']['percentage'] ?? 0 }}%</span>
                </div>
                <h3 style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ __('messages.presence') }}</h3>
                <p style="font-size: 1.875rem; font-weight: 900; color: var(--text-main); margin-top: 0.5rem; margin-bottom: 0;">{{ $chartData['attendance']['present'] ?? 0 }} <span style="font-size: 1.125rem; font-weight: 500; color: var(--text-muted);">/ {{ __('messages.total') }}</span></p>
            </a>
        </div>

        <!-- Academic Year Courses -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <h2 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">{{ __('messages.courses') }} - {{ strtoupper($academicYear) }}</h2>
                <a href="{{ route('admin.courses.index', ['academicYear' => $academicYear]) }}" style="font-size: 0.75rem; font-weight: 800; color: var(--accent-color); text-decoration: none; text-transform: uppercase;">{{ __('messages.view_all') }} →</a>
            </div>

            @if($courses->isEmpty())
                <div class="card-custom" style="padding: 3rem; text-align: center; border-style: dashed;">
                    <p style="color: var(--text-muted); font-size: 1rem; margin: 0;">No courses created for this academic year yet.</p>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                    @foreach($courses as $course)
                        <div class="card-custom" style="display: flex; flex-direction: column; gap: 1.5rem; position: relative;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between;">
                                <div style="width: 3rem; height: 3rem; background-color: rgba(79, 70, 229, 0.1); color: #4f46e5; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(79, 70, 229, 0.2);">
                                    <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                </div>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('admin.courses.edit', ['academicYear' => $academicYear, 'course' => $course]) }}" style="padding: 0.5rem; background-color: var(--bg-alt); color: var(--text-muted); border-radius: 0.5rem; border: 1px solid var(--border-color); text-decoration: none;" title="{{ __('messages.edit') }}">
                                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                </div>
                            </div>
                            <div>
                                <h4 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); margin: 0;">{{ $course->name }}</h4>
                                <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.25rem; font-family: monospace;">{{ $course->code }}</p>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 1.25rem; border-top: 1px solid var(--border-color);">
                                <div style="display: flex; items-center; gap: 0.5rem;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted);">{{ $course->lessons_count }}</span>
                                    <span style="font-size: 0.625rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-top: 0.125rem;">{{ __('messages.lessons') }}</span>
                                </div>
                                <a href="{{ route('admin.courses.lessons.index', ['academicYear' => $academicYear, 'course' => $course]) }}" style="font-size: 0.75rem; font-weight: 800; color: var(--accent-color); text-decoration: none;">{{ __('messages.view_course') }} →</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Charts Grid -->
        <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;" class="lg:grid-cols-2">
            <div class="card-custom">
                <h2 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); margin-bottom: 2rem; text-transform: uppercase; letter-spacing: 0.05em;">{{ __('messages.auto_revision_exam_stats') }}</h2>
                <div style="height: 320px;"><canvas id="autoRevisionExamStatsChart"></canvas></div>
            </div>

            <div class="card-custom">
                <h2 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); margin-bottom: 2rem; text-transform: uppercase; letter-spacing: 0.05em;">{{ __('messages.auto_revision_quiz_stats') }}</h2>
                <div style="height: 320px;"><canvas id="autoRevisionQuizStatsChart"></canvas></div>
            </div>

            <div class="card-custom">
                <h2 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); margin-bottom: 2rem; text-transform: uppercase; letter-spacing: 0.05em;">{{ __('messages.manual_exam_history') }}</h2>
                <div style="height: 320px;"><canvas id="examStatsChart"></canvas></div>
            </div>

            <div class="card-custom">
                <h2 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); margin-bottom: 2rem; text-transform: uppercase; letter-spacing: 0.05em;">{{ __('messages.manual_quiz_history') }}</h2>
                <div style="height: 320px;"><canvas id="quizStatsChart"></canvas></div>
            </div>

            <div class="card-custom lg:col-span-2">
                <h2 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); margin-bottom: 2rem; text-transform: uppercase; letter-spacing: 0.05em; text-align: center;">{{ __('messages.attendance_breakdown') }}</h2>
                <div style="height: 256px; display: flex; align-items: center; justify-content: center;">
                    <div style="width: 100%; max-width: 384px; height: 100%;"><canvas id="attendanceChart"></canvas></div>
                </div>
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

            const createChartObj = (id, labels, datasets) => {
                const ctx = document.getElementById(id);
                if (!ctx) return;
                new Chart(ctx, {
                    type: 'bar',
                    data: { labels: labels, datasets: datasets },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 110,
                                grid: { color: isDark ? '#1e293b' : '#f1f5f9' },
                                ticks: {
                                    color: isDark ? '#94a3b8' : '#64748b',
                                    callback: function(value) { return value <= 100 ? value + '%' : ''; }
                                }
                            },
                            y1: {
                                position: 'right',
                                beginAtZero: true,
                                grid: { display: false },
                                ticks: { color: isDark ? '#94a3b8' : '#64748b' }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { color: isDark ? '#94a3b8' : '#64748b' }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: { color: isDark ? '#f8fafc' : '#0f172a', font: { weight: 'bold' } }
                            }
                        }
                    }
                });
            };

            @if(!empty($chartData['autoRevisionExamStats']['avgScores']))
                createChartObj('autoRevisionExamStatsChart', @json($chartData['autoRevisionExamStats']['labels']), [
                    { label: '{{ __("messages.avg_percentage") }}', data: @json($chartData['autoRevisionExamStats']['avgScores']), backgroundColor: '#0d9488', borderRadius: 8, yAxisID: 'y' },
                    { label: '{{ __("messages.attempts") }}', data: @json($chartData['autoRevisionExamStats']['totalAttempts']), backgroundColor: '#6366f1', borderRadius: 8, yAxisID: 'y1' }
                ]);
            @endif

            @if(!empty($chartData['autoRevisionQuizStats']['avgScores']))
                createChartObj('autoRevisionQuizStatsChart', @json($chartData['autoRevisionQuizStats']['labels']), [
                    { label: '{{ __("messages.avg_percentage") }}', data: @json($chartData['autoRevisionQuizStats']['avgScores']), backgroundColor: '#db2777', borderRadius: 8, yAxisID: 'y' },
                    { label: '{{ __("messages.attempts") }}', data: @json($chartData['autoRevisionQuizStats']['totalAttempts']), backgroundColor: '#8b5cf6', borderRadius: 8, yAxisID: 'y1' }
                ]);
            @endif

            @if(!empty($chartData['examStats']['avgScores']))
                createChartObj('examStatsChart', @json($chartData['examStats']['labels']), [
                    { label: '{{ __("messages.avg_percentage") }}', data: @json($chartData['examStats']['avgScores']), backgroundColor: '#d97706', borderRadius: 8, yAxisID: 'y' },
                    { label: '{{ __("messages.attempts") }}', data: @json($chartData['examStats']['totalAttempts']), backgroundColor: '#4f46e5', borderRadius: 8, yAxisID: 'y1' }
                ]);
            @endif

            @if(!empty($chartData['quizStats']['avgScores']))
                createChartObj('quizStatsChart', @json($chartData['quizStats']['labels']), [
                    { label: '{{ __("messages.avg_percentage") }}', data: @json($chartData['quizStats']['avgScores']), backgroundColor: '#7c3aed', borderRadius: 8, yAxisID: 'y' },
                    { label: '{{ __("messages.attempts") }}', data: @json($chartData['quizStats']['totalAttempts']), backgroundColor: '#2dd4bf', borderRadius: 8, yAxisID: 'y1' }
                ]);
            @endif

            @if(!empty($chartData['attendance']['total']))
                new Chart(document.getElementById('attendanceChart'), {
                    type: 'doughnut',
                    data: {
                        labels: [
                            '{{ __("messages.present") }}',
                            '{{ __("messages.absent") }}'
                        ],
                        datasets: [{
                            data: [@json($chartData['attendance']['present']), @json($chartData['attendance']['absent'])],
                            backgroundColor: ['#10b981', '#f87171'],
                            borderWidth: 0,
                            hoverOffset: 20
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '80%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 30,
                                    usePointStyle: true,
                                    font: { weight: 'bold' },
                                    color: isDark ? '#f1f5f9' : '#1e293b'
                                }
                            }
                        }
                    }
                });
            @endif
        });
    </script>
    @endpush
</x-app-layout>
