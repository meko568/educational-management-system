<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('Manual Quizzes Management') }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">Record and manage offline quiz results for {{ strtoupper($academicYear ?? 'primary1') }}</p>
            </div>

            <a href="{{ route('admin.manual-quizzes.create', ['academicYear' => $academicYear ?? 'primary1']) }}"
               style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1.5rem; background-color: #ea580c; color: white; border-radius: 0.75rem; font-weight: 800; font-size: 0.875rem; text-decoration: none; box-shadow: 0 10px 15px -3px rgba(234, 88, 12, 0.2);">
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Create Quiz
            </a>
        </div>

        <!-- Content -->
        <div class="card-custom" style="padding: 0; overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}; font-size: 0.875rem;">
                    <thead style="background-color: var(--bg-alt);">
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Quiz Title</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: center;">Linked Exam</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: center;">Max Marks</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: center;">Status</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: var(--bg-card);">
                        @forelse($quizzes as $quiz)
                            <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.2s;">
                                <td style="padding: 1.25rem 1.5rem;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div style="width: 2.75rem; height: 2.75rem; background-color: rgba(234, 88, 12, 0.1); color: #ea580c; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                        </div>
                                        <div style="font-weight: 700; color: var(--text-main);">{{ $quiz->title }}</div>
                                    </div>
                                </td>
                                <td style="padding: 1.25rem 1.5rem; text-align: center;">
                                    <span style="font-size: 0.75rem; color: var(--text-muted); font-style: italic;">
                                        {{ $quiz->exam->title ?? '---' }}
                                    </span>
                                </td>
                                <td style="padding: 1.25rem 1.5rem; text-align: center;">
                                    <span style="padding: 0.25rem 0.625rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.5rem; font-size: 0.625rem; font-weight: 800; color: var(--text-main);">
                                        {{ $quiz->total_marks }}
                                    </span>
                                </td>
                                <td style="padding: 1.25rem 1.5rem; text-align: center;">
                                    @php
                                        $cls = match($quiz->status) {
                                            'draft' => 'background-color: var(--bg-alt); color: var(--text-muted); border: 1px solid var(--border-color);',
                                            'published' => 'background-color: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);',
                                            default => 'background-color: var(--bg-alt); color: var(--text-muted);'
                                        };
                                    @endphp
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 0.5rem; font-size: 0.625rem; font-weight: 800; text-transform: uppercase; {{ $cls }}">
                                        {{ $quiz->status }}
                                    </span>
                                </td>
                                <td style="padding: 1.25rem 1.5rem; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.5rem;">
                                        <a href="{{ route('admin.manual-quizzes.show', $quiz->id) }}" style="display: flex; align-items: center; gap: 0.375rem; padding: 0.4rem 0.75rem; background-color: rgba(79, 70, 229, 0.1); color: #4f46e5; border-radius: 0.5rem; text-decoration: none; font-size: 0.75rem; font-weight: 700;">
                                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            Results
                                        </a>
                                        <a href="{{ route('admin.manual-quizzes.edit', $quiz->id) }}" style="padding: 0.5rem; color: #f59e0b;" title="Edit">
                                            <svg style="width: 1.125rem; height: 1.125rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form action="{{ route('admin.manual-quizzes.destroy', $quiz->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this manual quiz record?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="padding: 0.5rem; background: transparent; border: none; color: #ef4444; cursor: pointer;">
                                                <svg style="width: 1.125rem; height: 1.125rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 5rem 1.5rem; text-align: center; color: var(--text-muted); font-style: italic;">No manual quizzes found for this period.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($quizzes->hasPages())
                <div style="padding: 1.25rem 1.5rem; background-color: var(--bg-alt); border-top: 1px solid var(--border-color);">
                    {{ $quizzes->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
