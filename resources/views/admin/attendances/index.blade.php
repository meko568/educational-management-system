<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('messages.attendance_management') }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">{{ __('messages.attendance_description') }} {{ strtoupper($academicYear ?? 'primary1') }}</p>
            </div>

            <a href="{{ route('admin.attendances.create', ['academicYear' => $academicYear ?? 'primary1']) }}"
               style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1.5rem; background-color: #b5501f; color: white; border-radius: 0.75rem; font-weight: 800; font-size: 0.875rem; text-decoration: none; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.2);">
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                {{ __('messages.mark_attendance') }}
            </a>
        </div>

        <!-- Attendance Table -->
        <div class="card-custom" style="padding: 0; overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}; font-size: 0.875rem;">
                    <thead style="background-color: var(--bg-alt);">
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">{{ __('messages.student') }}</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">{{ __('messages.log_date') }}</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: center;">{{ __('messages.status') }}</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">{{ __('messages.internal_notes') }}</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: var(--bg-card);">
                        @forelse($attendances as $attendance)
                            <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.2s;">
                                <td style="padding: 1.25rem 1.5rem;">
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 2.25rem; height: 2.25rem; border-radius: 0.625rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); color: var(--text-main); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem;">
                                            {{ substr($attendance->student->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: var(--text-main);">{{ $attendance->student->name }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted); font-family: monospace;">{{ $attendance->student->code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 1.25rem 1.5rem; color: var(--text-main); font-weight: 500;">
                                    {{ $attendance->date->format('M d, Y') }}
                                </td>
                                <td style="padding: 1.25rem 1.5rem; text-align: center;">
                                    @if($attendance->status === 'present')
                                        <span style="padding: 0.25rem 0.75rem; background-color: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 0.5rem; font-size: 0.625rem; font-weight: 800; text-transform: uppercase; border: 1px solid rgba(16, 185, 129, 0.2);">
                                            {{ __('messages.present') }}
                                        </span>
                                    @else
                                        <span style="padding: 0.25rem 0.75rem; background-color: rgba(239, 68, 68, 0.1); color: #ef4444; border-radius: 0.5rem; font-size: 0.625rem; font-weight: 800; text-transform: uppercase; border: 1px solid rgba(239, 68, 68, 0.2);">
                                            {{ __('messages.absent') }}
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 1.25rem 1.5rem; color: var(--text-muted); font-style: italic; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $attendance->notes ?? __('messages.no_notes') }}
                                </td>
                                <td style="padding: 1.25rem 1.5rem; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.5rem;">
                                        <a href="{{ route('admin.attendances.edit', $attendance->id) }}" style="padding: 0.5rem; color: var(--accent-color);" title="Edit">
                                            <svg style="width: 1.125rem; height: 1.125rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form action="{{ route('admin.attendances.destroy', $attendance->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('{{ __('messages.delete_record_question') }}');">
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
                                <td colspan="5" style="padding: 4rem 1.5rem; text-align: center; color: var(--text-muted); font-style: italic;">{{ __('messages.no_attendance_records') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($attendances->hasPages())
                <div style="padding: 1.25rem 1.5rem; background-color: var(--bg-alt); border-top: 1px solid var(--border-color);">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
