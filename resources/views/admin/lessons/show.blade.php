<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">Lesson Statistics: {{ $lesson->title }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem;">Course: <span style="font-weight: 700; color: var(--accent-color);">{{ $course->name }}</span></p>
            </div>

            <a href="{{ route('admin.courses.show', [$academicYear, $course]) }}"
               style="padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                {{ __('messages.back') }}
            </a>
        </div>

        <!-- Summary Cards -->
        <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;" class="md:grid-cols-3">
            <div class="card-custom" style="border-left: 4px solid #10b981;">
                <p style="font-size: 0.75rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">Students Watched</p>
                <p style="font-size: 1.875rem; font-weight: 900; color: #10b981; margin: 0.5rem 0 0 0;">{{ $watchedCount }}</p>
            </div>
            <div class="card-custom" style="border-left: 4px solid #ef4444;">
                <p style="font-size: 0.75rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">Not Watched Yet</p>
                <p style="font-size: 1.875rem; font-weight: 900; color: #ef4444; margin: 0.5rem 0 0 0;">{{ $notWatchedCount }}</p>
            </div>
            <div class="card-custom" style="border-left: 4px solid #b5501f;">
                <p style="font-size: 0.75rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">Watch Rate</p>
                <p style="font-size: 1.875rem; font-weight: 900; color: #b5501f; margin: 0.5rem 0 0 0;">{{ $stats->count() > 0 ? round(($watchedCount / $stats->count()) * 100) : 0 }}%</p>
            </div>
        </div>

        <!-- Detailed List -->
        <div class="card-custom" style="padding: 0; overflow: hidden;">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin: 0;">Student Watch Progress</h2>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                    <thead style="background-color: var(--bg-alt);">
                        <tr>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Student Name</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Code</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: center;">Status</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Completion</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Last Watched</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: var(--bg-card);">
                        @foreach($stats as $student)
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 1rem 1.5rem; font-weight: 600; color: var(--text-main);">{{ $student['name'] }}</td>
                                <td style="padding: 1rem 1.5rem; color: var(--text-muted);">#{{ $student['code'] }}</td>
                                <td style="padding: 1rem 1.5rem; text-align: center;">
                                    @if($student['watched'])
                                        <span style="padding: 0.25rem 0.625rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700; background-color: rgba(16, 185, 129, 0.1); color: #10b981;">Watched</span>
                                    @else
                                        <span style="padding: 0.25rem 0.625rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700; background-color: rgba(239, 68, 68, 0.1); color: #ef4444;">No Access</span>
                                    @endif
                                </td>
                                <td style="padding: 1rem 1.5rem;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div style="flex: 1; height: 0.5rem; background-color: var(--bg-alt); border-radius: 999px; overflow: hidden; max-width: 100px;">
                                            <div style="width: {{ $student['percentage'] }}%; height: 100%; background-color: {{ $student['percentage'] >= 80 ? '#10b981' : ($student['percentage'] > 0 ? '#f59e0b' : '#ef4444') }};"></div>
                                        </div>
                                        <span style="font-weight: 700; color: var(--text-main);">{{ $student['percentage'] }}%</span>
                                    </div>
                                </td>
                                <td style="padding: 1rem 1.5rem; color: var(--text-muted);">
                                    {{ $student['last_watched'] ? $student['last_watched']->format('M d, Y H:i') : 'Never' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
