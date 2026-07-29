<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin: 0;">
                {{ __('messages.courses') }}
            </h2>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0;">
                {{ __('Available courses for your academic level') }}
            </p>
        </div>

        <!-- Subscription Status Info -->
        <div style="padding: 1.5rem; border-radius: 1.5rem; border: 1px solid var(--border-color); background-color: var(--bg-alt);">
            <div style="display: flex; align-items: flex-start; gap: 1rem;">
                <div style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; background-color: rgba(79, 70, 229, 0.1); color: #4f46e5;">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <h3 style="font-size: 1rem; font-weight: 800; color: var(--text-main); margin: 0;">Course Access Logic</h3>
                    <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0.25rem 0 0 0;">
                        Courses are unlocked per month. Once you pay for a month, you have permanent access to its lessons for revision. New lessons appear automatically on their scheduled dates.
                    </p>
                </div>
            </div>
        </div>

        @if($courses->isEmpty())
            <div class="card-custom" style="padding: 4rem; text-align: center; border-style: dashed;">
                <p style="color: var(--text-muted); font-style: italic;">No courses have been published for your year yet.</p>
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                @foreach($courses as $course)
                    <div class="card-custom" style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 3rem; height: 3rem; background-color: rgba(79, 70, 229, 0.1); color: #4f46e5; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(79, 70, 229, 0.2);">
                                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            </div>
                            <div>
                                <h4 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); margin: 0;">{{ $course->name }}</h4>
                                <span style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">{{ date('F Y', mktime(0,0,0,$course->month, 1, $course->year)) }}</span>
                            </div>
                        </div>

                        <div style="margin-top: auto; display: flex; align-items: center; justify-content: space-between; padding-top: 1.25rem; border-top: 1px solid var(--border-color);">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="font-size: 0.875rem; font-weight: 800; color: var(--text-main);">{{ $course->lessons_count }}</span>
                                <span style="font-size: 0.625rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">{{ __('messages.lessons') }}</span>
                            </div>

                            @if($course->has_access)
                                <a href="{{ route('student.courses.show', $course) }}" style="padding: 0.625rem 1.25rem; background-color: #4f46e5; color: white; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 800; text-decoration: none; text-transform: uppercase; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">
                                    {{ __('messages.view_course') }} →
                                </a>
                            @else
                                <div style="padding: 0.625rem 1.25rem; background-color: var(--bg-alt); color: var(--text-muted); border: 1px solid var(--border-color); border-radius: 0.75rem; font-size: 0.75rem; font-weight: 800; cursor: not-allowed; text-transform: uppercase;">
                                    Locked 🔒
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
