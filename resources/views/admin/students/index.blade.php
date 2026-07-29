<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('messages.manage_students') }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">Manage and monitor all student profiles for {{ strtoupper($academicYear ?? 'primary1') }}</p>
            </div>

            <a href="{{ route('admin.students.create', ['academicYear' => $academicYear ?? 'primary1']) }}"
               style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1.5rem; background-color: #0d9488; color: white; border-radius: 0.75rem; font-weight: 800; font-size: 0.875rem; text-decoration: none; box-shadow: 0 10px 15px -3px rgba(13, 148, 136, 0.2);">
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                {{ __('messages.add_student') }}
            </a>
        </div>

        <!-- Students Table -->
        <div class="card-custom" style="padding: 0; overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}; font-size: 0.875rem;">
                    <thead style="background-color: var(--bg-alt);">
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">{{ __('messages.student_info') }}</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">{{ __('messages.access_credentials') }}</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">{{ __('messages.academic_year') }}</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">{{ __('messages.status') }}</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: var(--bg-card);">
                        @forelse($students as $student)
                            <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.2s;">
                                <td style="padding: 1rem 1.5rem;">
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 2.5rem; height: 2.5rem; border-radius: 9999px; background-color: rgba(79, 70, 229, 0.1); color: #4f46e5; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem; border: 1px solid rgba(79, 70, 229, 0.2);">
                                            {{ substr($student->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: var(--text-main);">{{ $student->name }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted); font-family: monospace;">{{ $student->code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 1rem 1.5rem;">
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; background-color: var(--bg-alt); padding: 0.125rem 0.375rem; border-radius: 0.25rem;">Pass:</span>
                                        <span style="font-weight: 700; color: var(--text-main); font-family: monospace;">{{ $student->plain_password ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td style="padding: 1rem 1.5rem;">
                                    <span style="padding: 0.25rem 0.625rem; background-color: rgba(20, 184, 166, 0.1); color: #14b8a6; border-radius: 0.5rem; font-size: 0.625rem; font-weight: 800; text-transform: uppercase;">
                                        {{ str_replace('_', ' ', $student->academicYear) }}
                                    </span>
                                </td>
                                <td style="padding: 1rem 1.5rem;">
                                    @if($student->hasValidSubscription())
                                        <span style="display: inline-flex; align-items: center; gap: 0.375rem; font-size: 0.75rem; font-weight: 700; color: #10b981;">
                                            <span style="width: 0.5rem; height: 0.5rem; border-radius: 9999px; background-color: #10b981;"></span> {{ __('messages.active') }}
                                        </span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; gap: 0.375rem; font-size: 0.75rem; font-weight: 700; color: #f59e0b;">
                                            <span style="width: 0.5rem; height: 0.5rem; border-radius: 9999px; background-color: #f59e0b;"></span> {{ __('messages.payment_due') }}
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.5rem;">
                                        <a href="{{ route('admin.students.show', $student->code) }}" style="padding: 0.5rem; color: var(--text-muted);" title="View">
                                            <svg style="width: 1.125rem; height: 1.125rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>
                                        <a href="{{ route('admin.students.edit', $student->code) }}" style="padding: 0.5rem; color: #f59e0b;" title="Edit">
                                            <svg style="width: 1.125rem; height: 1.125rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <a href="{{ route('admin.students.payment', $student) }}" style="padding: 0.5rem; color: #14b8a6;" title="Payment">
                                            <svg style="width: 1.125rem; height: 1.125rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 3v2m3-2v2m3-2v2m3-2v2m3 13h1a2 2 0 002-2V9.5a2 2 0 00-2-2H5.5a2 2 0 00-2 2v10a2 2 0 002 2h1m6-13h2m-6 5h8m-8 3h8m-8 3h6" /></svg>
                                        </a>
                                        <form action="{{ route('admin.students.destroy', $student->code) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this student?');">
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
                                <td colspan="5" style="padding: 4rem 1.5rem; text-align: center; color: var(--text-muted); font-style: italic;">No students found for this grade.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($students->hasPages())
                <div style="padding: 1.25rem 1.5rem; background-color: var(--bg-alt); border-top: 1px solid var(--border-color);">
                    {{ $students->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
