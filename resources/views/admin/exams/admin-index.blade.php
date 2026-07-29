<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('Auto-Revision Exams') }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">Manage online automated assessments and grading systems</p>
            </div>

            <a href="{{ route('admin.exams.create') }}"
               style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1.5rem; background-color: #db2777; color: white; border-radius: 0.75rem; font-weight: 800; font-size: 0.875rem; text-decoration: none; box-shadow: 0 10px 15px -3px rgba(219, 39, 119, 0.2);">
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Create Exam
            </a>
        </div>

        <!-- Content -->
        <div class="card-custom" style="padding: 0; overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}; font-size: 0.875rem;">
                    <thead style="background-color: var(--bg-alt);">
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Exam Details</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: center;">Grade</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: center;">Stats</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Timeline</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: var(--bg-card);">
                        @forelse($exams as $exam)
                            <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.2s;">
                                <td style="padding: 1.25rem 1.5rem;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div style="width: 2.75rem; height: 2.75rem; background-color: rgba(219, 39, 119, 0.1); color: #db2777; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: var(--text-main);">{{ $exam->title }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted); line-height: 1.4; margin-top: 0.125rem;">{{ $exam->description ?? 'No description' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 1.25rem 1.5rem; text-align: center;">
                                    <span style="padding: 0.25rem 0.625rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.5rem; font-size: 0.625rem; font-weight: 800; color: var(--text-main); text-transform: uppercase;">
                                        {{ $exam->grade }}
                                    </span>
                                </td>
                                <td style="padding: 1.25rem 1.5rem;">
                                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.25rem;">
                                        <div style="display: flex; align-items: center; gap: 0.375rem;">
                                            <span style="font-size: 0.625rem; font-weight: 800; color: var(--text-muted);">Q:</span>
                                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-main);">{{ $exam->questions->count() }}</span>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 0.375rem;">
                                            <span style="font-size: 0.625rem; font-weight: 800; color: var(--text-muted);">A:</span>
                                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--accent-color);">{{ $exam->attempts->count() }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 1.25rem 1.5rem;">
                                    <div style="font-size: 0.625rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.25rem;">Ends On</div>
                                    <div style="font-weight: 700; color: var(--text-main);">{{ $exam->end_datetime->format('M d, Y') }}</div>
                                    <div style="font-size: 0.625rem; font-weight: 500; color: var(--text-muted);">{{ $exam->duration_minutes }} min</div>
                                </td>
                                <td style="padding: 1.25rem 1.5rem; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.5rem;">
                                        <a href="{{ route('admin.exams.show', $exam->id) }}" style="padding: 0.5rem; color: var(--text-muted); transition: color 0.2s;" title="View">
                                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>
                                        <a href="{{ route('admin.exams.edit', $exam->id) }}" style="padding: 0.5rem; color: #f59e0b; transition: color 0.2s;" title="Edit">
                                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" style="display: inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete this exam?')" style="padding: 0.5rem; background: transparent; border: none; color: #ef4444; cursor: pointer;">
                                                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 5rem 1.5rem; text-align: center; color: var(--text-muted); font-style: italic;">No auto-revision exams created yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
