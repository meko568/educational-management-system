<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ $exam->title }} - Results</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">Max Score: <span style="font-weight: 700; color: var(--accent-color);">{{ $exam->total_marks }}</span> • Record offline scores</p>
            </div>

            <a href="{{ route('admin.manual-exams.index', ['academicYear' => $exam->academicYear]) }}"
               style="padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                {{ __('messages.back') }}
            </a>
        </div>

        <!-- Add Result Section -->
        <div class="card-custom">
            <h3 style="font-size: 1rem; font-weight: 800; color: var(--text-main); margin: 0 0 1.5rem 0; text-transform: uppercase; letter-spacing: 0.05em;">Record Student Mark</h3>

            <form method="POST" action="{{ route('admin.manual-exams.storeResult', $exam->id) }}" style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;" class="md:grid-cols-3">
                @csrf
                <input type="hidden" name="academicYear" value="{{ $exam->academicYear ?? 'primary1' }}">

                <!-- Student -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="student_code" style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted);">{{ __('messages.student') }}</label>
                    <select id="student_code" name="student_code" required
                            style="width: 100%; padding: 0.625rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem; cursor: pointer;">
                        <option value="">-- Select Student --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->code }}">{{ $student->code }} - {{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Marks -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="marks_obtained" style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted);">Score (0-{{ $exam->total_marks }})</label>
                    <input id="marks_obtained" name="marks_obtained" type="number" min="0" max="{{ $exam->total_marks }}" required
                           style="width: 100%; padding: 0.625rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;" placeholder="e.g., 85">
                </div>

                <!-- Action -->
                <div style="display: flex; align-items: flex-end;">
                    <button type="submit" style="width: 100%; padding: 0.625rem 1rem; background-color: #4f46e5; color: white; border: none; border-radius: 0.75rem; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1);">
                        Save Record
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Table -->
        <div class="card-custom" style="padding: 0; overflow: hidden;">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color); background-color: var(--bg-alt);">
                <h3 style="font-size: 0.875rem; font-weight: 800; color: var(--text-main); margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Recorded Results</h3>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}; font-size: 0.875rem;">
                    <thead style="background-color: var(--bg-alt);">
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Student</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: center;">Result</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: center;">Percentage</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: var(--bg-card);">
                        @forelse($results as $result)
                            <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.2s;">
                                <td style="padding: 1.25rem 1.5rem;">
                                    <div style="font-weight: 700; color: var(--text-main);">{{ $result->student->name }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted); font-family: monospace;">{{ $result->student->code }}</div>
                                </td>
                                <td style="padding: 1.25rem 1.5rem; text-align: center;">
                                    <span style="padding: 0.25rem 0.625rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.5rem; font-size: 0.75rem; font-weight: 800; color: var(--text-main);">
                                        {{ $result->marks_obtained }} / {{ $exam->total_marks }}
                                    </span>
                                </td>
                                <td style="padding: 1.25rem 1.5rem; text-align: center;">
                                    @php $pct = ($result->marks_obtained / $exam->total_marks) * 100; @endphp
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                        <div style="width: 3rem; height: 0.375rem; background-color: var(--bg-alt); border-radius: 9999px; overflow: hidden;">
                                            <div style="width: {{ $pct }}%; height: 100%; background-color: {{ $pct >= 50 ? '#10b981' : '#ef4444' }};"></div>
                                        </div>
                                        <span style="font-weight: 700; color: {{ $pct >= 50 ? '#10b981' : '#ef4444' }};">{{ number_format($pct, 1) }}%</span>
                                    </div>
                                </td>
                                <td style="padding: 1.25rem 1.5rem; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">
                                    <form action="{{ route('admin.exams.deleteResult', [$exam->id, $result->id]) }}" method="POST" onsubmit="return confirm('Delete this result?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="padding: 0.5rem; background: transparent; border: none; color: #ef4444; cursor: pointer;">
                                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding: 5rem 1.5rem; text-align: center; color: var(--text-muted); font-style: italic;">No results recorded yet for this exam.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
