<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem; max-width: 64rem; margin: 0 auto;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ $lesson->title }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem;">
                    {{ __('messages.courses') }}: <a href="{{ route('student.courses.show', $course) }}" style="color: var(--accent-color); text-decoration: none; font-weight: 600;">{{ $course->name }}</a>
                </p>
            </div>

            <a href="{{ route('student.courses.show', $course) }}"
               style="display: flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                {{ __('messages.back') }}
            </a>
        </div>

        @if(!$hasAccess)
            <div style="padding: 3rem; background-color: rgba(239, 68, 68, 0.05); border: 2px dashed rgba(239, 68, 68, 0.2); border-radius: 1.5rem; text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1.5rem;">🔒</div>
                <h3 style="color: #991b1b; font-weight: 800; font-size: 1.25rem; margin: 0;">Access Restricted</h3>
                <p style="color: #b91c1c; margin-top: 0.5rem;">Your subscription has expired. Please contact administration to regain access.</p>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 2rem;">

                <!-- Video Player Section -->
                @if($lesson->video_url)
                    <div class="card-custom" style="padding: 0.5rem; overflow: hidden; background-color: #000;">
                        @php
                            $videoId = '';
                            $isYoutube = false;
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $lesson->video_url, $matches)) {
                                $videoId = $matches[1];
                                $isYoutube = true;
                            }
                        @endphp

                        <div id="player-container" style="position: relative; width: 100%; aspect-ratio: 16/9;">
                            @if($isYoutube)
                                <div class="plyr__video-embed" id="player">
                                    <iframe
                                        src="https://www.youtube.com/embed/{{ $videoId }}?origin={{ urlencode(url('/')) }}&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                                        allowfullscreen
                                        allowtransparency
                                        allow="autoplay"
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                                    ></iframe>
                                </div>
                            @else
                                <video id="player" playsinline controls style="width: 100%; height: 100%;">
                                    <source src="{{ $lesson->video_url }}" type="video/mp4" />
                                </video>
                            @endif
                        </div>
                    </div>

                    <!-- Attendance Progress Info -->
                    <div id="attendance-status" style="display: none; padding: 1rem; border-radius: 1rem; background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); align-items: center; gap: 0.75rem;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p style="font-size: 0.875rem; font-weight: 700; color: #065f46; margin: 0;">Attendance marked automatically (Watched 80%+)</p>
                    </div>
                @endif

                <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;" class="lg:grid-cols-3">
                    <!-- Left: Description -->
                    <div class="lg:col-span-2">
                        <div class="card-custom">
                            <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">Lesson Overview</h3>
                            <p style="color: var(--text-muted); line-height: 1.6; margin: 0;">
                                {{ $lesson->description ?? 'No detailed description available for this lesson.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Right: Materials -->
                    <div class="lg:col-span-1">
                        <div class="card-custom" style="display: flex; flex-direction: column; gap: 1.5rem;">
                            <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Materials</h3>

                            @if($lesson->pdf_url)
                                <a href="{{ $lesson->pdf_url }}" target="_blank" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 1rem; text-decoration: none; transition: all 0.2s;" class="hover-card">
                                    <div style="width: 2.5rem; height: 2.5rem; background-color: rgba(239, 68, 68, 0.1); color: #ef4444; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                    <div style="flex: 1;">
                                        <p style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); margin: 0;">Study Guide (PDF)</p>
                                        <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0;">Download lesson notes</p>
                                    </div>
                                </a>
                            @else
                                <p style="color: var(--text-muted); font-size: 0.875rem; font-style: italic; text-align: center;">No supplementary files available.</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        @endif

        <!-- Footer Navigation -->
        <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 2rem; border-top: 1px solid var(--border-color);">
            <div style="display: flex; flex-direction: column;">
                <span style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">Progress</span>
                <p style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); margin: 0;">Lesson {{ $lesson->order + 1 }} of {{ $lessonsCount }}</p>
            </div>

            <a href="{{ route('student.courses.show', $course) }}" style="padding: 0.625rem 1.25rem; background-color: var(--bg-alt); color: var(--text-main); border: 1px solid var(--border-color); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none; text-transform: uppercase;">
                {{ __('messages.view_all') }}
            </a>
        </div>
    </div>

    @push('scripts')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const player = new Plyr('#player', {
                fullscreen: { enabled: true, fallback: true, iosNative: true },
                youtube: { noCookie: true, rel: 0, showinfo: 0, iv_load_policy: 3, modestbranding: 1 }
            });

            let attendanceMarked = false;
            const threshold = 0.8; // 80%

            player.on('timeupdate', event => {
                const currentPercentage = Math.floor((player.currentTime / player.duration) * 100);

                // Track progress every 5% increment or when reaching threshold
                if (currentPercentage % 5 === 0 || currentPercentage >= 80) {
                    updateProgress(currentPercentage);
                }

                if (attendanceMarked) return;

                if (currentPercentage >= 80) {
                    attendanceMarked = true;
                    // Attendance is now handled inside updateProgress when >= 80
                }
            });

            let lastReportedPercentage = 0;

            function updateProgress(percentage) {
                if (percentage <= lastReportedPercentage && percentage < 80) return;
                lastReportedPercentage = percentage;

                fetch('{{ route("student.attendance.mark") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        lesson_id: {{ $lesson->id }},
                        percentage: percentage
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success' && percentage >= 80) {
                        document.getElementById('attendance-status').style.display = 'flex';
                    }
                })
                .catch(err => console.error('Progress Error:', err));
            }
        });
    </script>
    <style>
        .plyr { border-radius: 1rem; }
        .dark .plyr--full-ui.plyr--video .plyr__control--overlaid { background: rgba(99, 102, 241, .8); }
        .dark .plyr--full-ui.plyr--video .plyr__control:hover { background: #b5501f; }
        .dark .plyr__control--overlaid { color: #fff; }
    </style>
    @endpush
</x-app-layout>
