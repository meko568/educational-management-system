<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">Student Profile: {{ $student->name }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">Viewing full academic record and system identity</p>
            </div>

            <a href="{{ route('admin.students.index', ['academicYear' => $student->academicYear]) }}"
               style="padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                {{ __('messages.back_to_list') }}
            </a>
        </div>

        <!-- Identity Details -->
        <div class="card-custom">
            <h3 style="font-size: 1rem; font-weight: 800; color: var(--text-main); margin: 0 0 1.5rem 0; text-transform: uppercase; letter-spacing: 0.05em;">Institutional Identity</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
                <div>
                    <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ __('messages.name') }}</p>
                    <p style="font-size: 1rem; font-weight: 700; color: var(--text-main); margin: 0.25rem 0 0 0;">{{ $student->name }}</p>
                </div>
                <div>
                    <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ __('messages.code') }}</p>
                    <p style="font-size: 1rem; font-weight: 700; color: var(--text-main); margin: 0.25rem 0 0 0; font-family: monospace;">{{ $student->code }}</p>
                </div>
                <div>
                    <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ __('messages.academic_year') }}</p>
                    <p style="font-size: 1rem; font-weight: 700; color: var(--text-main); margin: 0.25rem 0 0 0;">{{ strtoupper(str_replace('_', ' ', $student->academicYear)) }}</p>
                </div>
                <div>
                    <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">Login Password</p>
                    <p style="font-size: 1rem; font-weight: 700; color: #4f46e5; margin: 0.25rem 0 0 0; font-family: monospace;">{{ $student->plain_password ?? '********' }}</p>
                </div>
            </div>
        </div>

        <!-- Progress Summary -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem;">
            <div class="card-custom" style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <p style="font-size: 0.75rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">Exam Average</p>
                    <span style="font-size: 1.25rem; font-weight: 900; color: #4f46e5;">{{ round($totalExamAvg) }}%</span>
                </div>
                <div style="height: 0.5rem; background-color: var(--bg-alt); border-radius: 999px; overflow: hidden;">
                    <div style="width: {{ $totalExamAvg }}%; height: 100%; background-color: #4f46e5;"></div>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.625rem; font-weight: 700; color: var(--text-muted);">
                    <span>Manual: {{ round($manualExamAvg) }}%</span>
                    <span>Auto: {{ round($autoExamAvg) }}%</span>
                </div>
            </div>

            <div class="card-custom" style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <p style="font-size: 0.75rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">Quiz Average</p>
                    <span style="font-size: 1.25rem; font-weight: 900; color: #10b981;">{{ round($totalQuizAvg) }}%</span>
                </div>
                <div style="height: 0.5rem; background-color: var(--bg-alt); border-radius: 999px; overflow: hidden;">
                    <div style="width: {{ $totalQuizAvg }}%; height: 100%; background-color: #10b981;"></div>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.625rem; font-weight: 700; color: var(--text-muted);">
                    <span>Manual: {{ round($manualQuizAvg) }}%</span>
                    <span>Auto: {{ round($autoQuizAvg) }}%</span>
                </div>
            </div>

            <div class="card-custom" style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <p style="font-size: 0.75rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">Lesson Progress</p>
                    <span style="font-size: 1.25rem; font-weight: 900; color: #f59e0b;">{{ round($lessonProgress) }}%</span>
                </div>
                <div style="height: 0.5rem; background-color: var(--bg-alt); border-radius: 999px; overflow: hidden;">
                    <div style="width: {{ $lessonProgress }}%; height: 100%; background-color: #f59e0b;"></div>
                </div>
                <p style="font-size: 0.625rem; font-weight: 700; color: var(--text-muted); margin: 0;">Completion of assigned curriculum videos</p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;" class="lg:grid-cols-2">
            <!-- Attendance History -->
            <div class="card-custom" style="padding: 0; overflow: hidden;">
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); background-color: var(--bg-alt);">
                    <h3 style="font-size: 0.875rem; font-weight: 800; color: var(--text-main); margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Attendance History</h3>
                </div>
                <div style="overflow-x: auto; max-height: 400px; overflow-y: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                        <thead style="background-color: var(--bg-alt); position: sticky; top: 0; z-index: 10;">
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Date</th>
                                <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: center;">Status</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: var(--bg-card);">
                            @forelse($student->attendances->sortByDesc('date') as $attendance)
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 1rem 1.5rem; color: var(--text-main); font-weight: 500;">{{ $attendance->date->format('M d, Y') }}</td>
                                    <td style="padding: 1rem 1.5rem; text-align: center;">
                                        <span style="padding: 0.25rem 0.625rem; border-radius: 0.5rem; font-size: 0.625rem; font-weight: 800; text-transform: uppercase; {{ $attendance->status === 'present' ? 'background-color: rgba(16, 185, 129, 0.1); color: #10b981;' : 'background-color: rgba(239, 68, 68, 0.1); color: #ef4444;' }}">
                                            {{ $attendance->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="2" style="padding: 3rem; text-align: center; color: var(--text-muted); font-style: italic;">No attendance records found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Performance Grid -->
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                <!-- Exams -->
                <div class="card-custom" style="padding: 0; overflow: hidden;">
                    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); background-color: var(--bg-alt);">
                        <h3 style="font-size: 0.875rem; font-weight: 800; color: var(--text-main); margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Exam Results</h3>
                    </div>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                            <tbody style="background-color: var(--bg-card);">
                                @forelse($student->examResults as $result)
                                    <tr style="border-bottom: 1px solid var(--border-color);">
                                        <td style="padding: 1rem 1.5rem;">
                                            <div style="font-weight: 700; color: var(--text-main);">{{ $result->exam->title ?? 'N/A' }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $result->created_at->format('M d, Y') }}</div>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; text-align: right;">
                                            <span style="font-weight: 800; color: var(--text-main);">{{ $result->marks_obtained }}</span>
                                            <span style="font-size: 0.75rem; color: var(--text-muted);"> / {{ $result->exam->total_marks ?? '?' }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" style="padding: 2rem; text-align: center; color: var(--text-muted); font-style: italic;">No exam results.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quizzes -->
                <div class="card-custom" style="padding: 0; overflow: hidden;">
                    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); background-color: var(--bg-alt);">
                        <h3 style="font-size: 0.875rem; font-weight: 800; color: var(--text-main); margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Quiz Results</h3>
                    </div>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                            <tbody style="background-color: var(--bg-card);">
                                @forelse($student->quizResults as $result)
                                    <tr style="border-bottom: 1px solid var(--border-color);">
                                        <td style="padding: 1rem 1.5rem;">
                                            <div style="font-weight: 700; color: var(--text-main);">{{ $result->quiz->title ?? 'N/A' }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $result->created_at->format('M d, Y') }}</div>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; text-align: right;">
                                            <span style="font-weight: 800; color: var(--text-main);">{{ $result->marks_obtained }}</span>
                                            <span style="font-size: 0.75rem; color: var(--text-muted);"> / {{ $result->quiz->total_marks ?? '?' }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" style="padding: 2rem; text-align: center; color: var(--text-muted); font-style: italic;">No quiz results.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Auto-Revision Attempts -->
                <div class="card-custom" style="padding: 0; overflow: hidden;">
                    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); background-color: var(--bg-alt);">
                        <h3 style="font-size: 0.875rem; font-weight: 800; color: var(--text-main); margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Auto-Revision History</h3>
                    </div>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                            <tbody style="background-color: var(--bg-card);">
                                @foreach($student->adminExamAttempts as $attempt)
                                    <tr style="border-bottom: 1px solid var(--border-color);">
                                        <td style="padding: 1rem 1.5rem;">
                                            <div style="font-weight: 700; color: var(--text-main);">[Exam] {{ $attempt->exam->title ?? 'N/A' }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $attempt->submitted_at ? $attempt->submitted_at->format('M d, Y') : 'In Progress' }}</div>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; text-align: right;">
                                            <span style="font-weight: 800; color: #4f46e5;">{{ $attempt->score }}%</span>
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach($student->adminQuizAttempts as $attempt)
                                    <tr style="border-bottom: 1px solid var(--border-color);">
                                        <td style="padding: 1rem 1.5rem;">
                                            <div style="font-weight: 700; color: var(--text-main);">[Quiz] {{ $attempt->quiz->title ?? 'N/A' }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $attempt->submitted_at ? $attempt->submitted_at->format('M d, Y') : 'In Progress' }}</div>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; text-align: right;">
                                            <span style="font-weight: 800; color: #10b981;">{{ $attempt->score }}%</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
