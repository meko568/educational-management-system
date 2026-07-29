<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ $course->name }}</h1>
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-top: 0.25rem;">
                    <span style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; background-color: var(--bg-alt); padding: 0.125rem 0.375rem; border-radius: 0.25rem; border: 1px solid var(--border-color);">{{ $course->code }}</span>
                    <span style="font-size: 0.75rem; color: var(--text-muted);">{{ strtoupper($academicYear) }}</span>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <a href="{{ route('admin.courses.index', $academicYear) }}"
                   style="display: flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Back
                </a>
                <a href="{{ route('admin.courses.lessons.create', [$academicYear, $course]) }}"
                   style="display: flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.25rem; background-color: #10b981; color: white; border-radius: 0.75rem; font-size: 0.875rem; font-weight: 800; text-decoration: none; box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);">
                    <svg style="width: 1.125rem; height: 1.125rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Add Lesson
                </a>
            </div>
        </div>

        @if($course->description)
            <div class="card-custom" style="background-color: var(--bg-alt); border-style: dashed;">
                <p style="color: var(--text-muted); font-size: 0.875rem; margin: 0; line-height: 1.6;">{{ $course->description }}</p>
            </div>
        @endif

        <!-- Lessons List -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">{{ __('messages.lessons') }} ({{ $lessons->count() }})</h3>
                <div style="flex: 1; height: 1px; background-color: var(--border-color);"></div>
            </div>

            @if($lessons->isEmpty())
                <div class="card-custom" style="padding: 4rem; text-align: center; border-style: dashed;">
                    <div style="width: 3.5rem; height: 3.5rem; background-color: var(--bg-alt); color: var(--text-muted); border-radius: 9999px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem auto;">
                        <svg style="width: 1.75rem; height: 1.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <p style="color: var(--text-muted); font-style: italic;">No lessons published for this course yet.</p>
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($lessons as $lesson)
                        <div class="card-custom" style="display: flex; flex-direction: column; gap: 1.25rem;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 1.5rem;" class="flex-col sm:flex-row sm:items-center">
                                <div style="display: flex; align-items: center; gap: 1.25rem; flex: 1;">
                                    <div style="width: 2.5rem; height: 2.5rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.625rem; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.875rem; flex-shrink: 0;">
                                        {{ $lesson->order }}
                                    </div>
                                    <div style="flex: 1;">
                                        <h4 style="font-size: 1rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ $lesson->title }}</h4>
                                        @if($lesson->description)
                                            <p style="font-size: 0.8125rem; color: var(--text-muted); margin: 0.25rem 0 0 0; line-height: 1.5;">{{ $lesson->description }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div style="display: flex; align-items: center; gap: 0.75rem; flex-shrink: 0;">
                                    <div style="display: flex; gap: 0.5rem; margin-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: 1rem;">
                                        @if($lesson->video_url)
                                            <div title="Video" style="width: 2rem; height: 2rem; background-color: rgba(59, 130, 246, 0.1); color: #3b82f6; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                            </div>
                                        @endif
                                        @if($lesson->pdf_url)
                                            <div title="PDF" style="width: 2rem; height: 2rem; background-color: rgba(239, 68, 68, 0.1); color: #ef4444; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div style="display: flex; gap: 0.375rem; border-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 1px solid var(--border-color); padding-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 0.75rem;">
                                        <a href="{{ route('admin.courses.lessons.show', [$academicYear, $course, $lesson]) }}" style="padding: 0.5rem; background-color: var(--bg-alt); color: #10b981; border-radius: 0.5rem; border: 1px solid var(--border-color); text-decoration: none;" title="View Stats">
                                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                        </a>
                                        <a href="{{ route('admin.courses.lessons.edit', [$academicYear, $course, $lesson]) }}" style="padding: 0.5rem; background-color: var(--bg-alt); color: #f59e0b; border-radius: 0.5rem; border: 1px solid var(--border-color); text-decoration: none;">
                                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.courses.lessons.destroy', [$academicYear, $course, $lesson]) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this lesson?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="padding: 0.5rem; background-color: rgba(239, 68, 68, 0.1); color: #ef4444; border-radius: 0.5rem; border: 1px solid rgba(239, 68, 68, 0.2); cursor: pointer;">
                                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
