<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem; max-width: 64rem; margin: 0 auto;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ $course->name }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem;">
                    {{ __('messages.academic_year_short') }}: {{ strtoupper($student->academicYear) }} • {{ $lessons->count() }} {{ __('messages.lessons') }}
                </p>
            </div>

            <a href="{{ route('student.courses.index') }}"
               style="display: flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                {{ __('messages.back') }}
            </a>
        </div>

        @if($course->description)
            <div class="card-custom" style="background-color: var(--bg-alt); border-style: dashed;">
                <p style="color: var(--text-muted); font-size: 0.875rem; margin: 0; line-height: 1.6;">{{ $course->description }}</p>
            </div>
        @endif

        <!-- Access Alert -->
        @if(!$hasAccess)
            <div style="padding: 1.5rem; border-radius: 1rem; background-color: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.1); display: flex; align-items: center; gap: 1rem;">
                <div style="width: 2.5rem; height: 2.5rem; background-color: rgba(239, 68, 68, 0.1); color: #ef4444; border-radius: 9999px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <p style="font-size: 0.875rem; color: #b91c1c; font-weight: 600; margin: 0;">Please complete your monthly payment to access lesson materials.</p>
            </div>
        @else
            <div style="padding: 1rem 1.5rem; border-radius: 1rem; background-color: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.1); display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 0.5rem; height: 0.5rem; border-radius: 9999px; background-color: #10b981;"></div>
                <p style="font-size: 0.8125rem; color: #047857; font-weight: 700; margin: 0;">
                    Full access active until {{ $student->getSubscriptionExpiryDate()->format('M d, Y') }}
                </p>
            </div>
        @endif

        <!-- Lessons List -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Course Lessons</h3>
                <div style="flex: 1; height: 1px; background-color: var(--border-color);"></div>
            </div>

            @if($lessons->isEmpty())
                <div class="card-custom" style="padding: 4rem; text-align: center; border-style: dashed;">
                    <p style="color: var(--text-muted); font-style: italic;">No lessons have been uploaded for this course yet.</p>
                </div>
            @else
                <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
                    @foreach($lessons as $lesson)
                        <div class="card-custom" style="display: flex; align-items: center; gap: 1.5rem; padding: 1.25rem 2rem;">
                            <div style="width: 2.5rem; height: 2.5rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.875rem; flex-shrink: 0;">
                                {{ $lesson->order + 1 }}
                            </div>

                            <div style="flex: 1;">
                                <h4 style="font-size: 1rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ $lesson->title }}</h4>
                                <div style="display: flex; align-items: center; gap: 1rem; margin-top: 0.25rem;">
                                    @if($lesson->video_url)
                                        <span style="display: flex; align-items: center; gap: 0.25rem; font-size: 0.75rem; color: #3b82f6; font-weight: 600;">
                                            <svg style="width: 0.875rem; height: 0.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Video
                                        </span>
                                    @endif
                                    @if($lesson->pdf_url)
                                        <span style="display: flex; align-items: center; gap: 0.25rem; font-size: 0.75rem; color: #ef4444; font-weight: 600;">
                                            <svg style="width: 0.875rem; height: 0.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            PDF
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if($hasAccess)
                                <a href="{{ route('student.lessons.show', [$course, $lesson]) }}"
                                   style="padding: 0.5rem 1.25rem; background-color: var(--accent-color); color: white; border-radius: 0.625rem; font-size: 0.75rem; font-weight: 800; text-decoration: none; text-transform: uppercase;">
                                    Start →
                                </a>
                            @else
                                <div style="padding: 0.5rem 1.25rem; background-color: var(--bg-alt); color: var(--text-muted); border: 1px solid var(--border-color); border-radius: 0.625rem; font-size: 0.75rem; font-weight: 800; cursor: not-allowed;">
                                    Locked 🔒
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
