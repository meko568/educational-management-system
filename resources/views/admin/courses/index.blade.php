<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('messages.curriculum_management') }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">{{ __('messages.curriculum_description') }} {{ strtoupper($academicYear ?? 'primary1') }}</p>
            </div>

            <a href="{{ route('admin.courses.create', $academicYear) }}"
               style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1.5rem; background-color: #7c3aed; color: white; border-radius: 0.75rem; font-weight: 800; font-size: 0.875rem; text-decoration: none; box-shadow: 0 10px 15px -3px rgba(124, 58, 237, 0.2);">
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                {{ __('messages.new_course') }}
            </a>
        </div>

        <!-- Courses Grid -->
        @if($courses->isEmpty())
            <div class="card-custom" style="padding: 4rem; text-align: center; border-style: dashed;">
                <p style="color: var(--text-muted); font-style: italic;">{{ __('messages.no_courses') }}</p>
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
                @foreach($courses as $course)
                    <div class="card-custom" style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; align-items: flex-start; justify-content: space-between;">
                            <div style="width: 3.5rem; height: 3.5rem; background-color: rgba(124, 58, 237, 0.1); color: #7c3aed; border-radius: 1rem; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(124, 58, 237, 0.2);">
                                <svg style="width: 1.75rem; height: 1.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            </div>

                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.courses.edit', [$academicYear, $course]) }}" style="padding: 0.5rem; background-color: var(--bg-alt); color: #f59e0b; border-radius: 0.5rem; border: 1px solid var(--border-color); text-decoration: none;">
                                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.courses.destroy', [$academicYear, $course]) }}" style="display: inline;" onsubmit="return confirm('{{ __('messages.delete_course_question') }}');">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="padding: 0.5rem; background-color: rgba(239, 68, 68, 0.1); color: #ef4444; border-radius: 0.5rem; border: 1px solid rgba(239, 68, 68, 0.2); cursor: pointer;">
                                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div>
                            <h4 style="font-size: 1.25rem; font-weight: 800; color: var(--text-main); margin: 0;">{{ $course->name }}</h4>
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.25rem;">
                                <span style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; background-color: var(--bg-alt); padding: 0.125rem 0.375rem; border-radius: 0.25rem; border: 1px solid var(--border-color);">{{ $course->code }}</span>
                            </div>
                        </div>

                        <div style="margin-top: auto; display: flex; align-items: center; justify-content: space-between; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="font-size: 1rem; font-weight: 800; color: var(--text-main);">{{ $course->lessons_count }}</span>
                                <span style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">{{ __('messages.lessons') }}</span>
                            </div>
                            <a href="{{ route('admin.courses.show', [$academicYear, $course]) }}" style="font-size: 0.75rem; font-weight: 800; color: var(--accent-color); text-decoration: none; text-transform: uppercase;">{{ __('messages.view_course') }} →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
