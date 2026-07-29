<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">Academic Session Selection</h1>
            <p style="color: var(--text-muted); margin: 0;">Welcome back, {{ auth()->user()->name }}. Select a session to manage.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">
            @forelse($yearStats as $stat)
                <a href="{{ route('academic-year.select', ['academicYear' => $stat['academicYear']]) }}"
                   style="text-decoration: none;" class="card-custom">

                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
                        <div style="width: 3.5rem; height: 3.5rem; background-color: var(--bg-sidebar); color: white; border-radius: 1rem; display: flex; align-items: center; justify-content: center; shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
                            <svg style="width: 1.75rem; height: 1.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <span style="font-size: 0.625rem; font-weight: 900; color: #14b8a6; background-color: rgba(20, 184, 166, 0.1); padding: 0.375rem 0.75rem; border-radius: 9999px; text-transform: uppercase; letter-spacing: 0.1em;">Active Session</span>
                    </div>

                    <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text-main); margin: 0 0 1.5rem 0; text-transform: uppercase; letter-spacing: 0.05em;">
                        {{ str_replace('_', ' ', $stat['academicYear']) }}
                    </h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                        <div style="padding: 1rem; border-radius: 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color);">
                            <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; margin: 0 0 0.25rem 0;">Students</p>
                            <p style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ $stat['students'] }}</p>
                        </div>
                        <div style="padding: 1rem; border-radius: 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color);">
                            <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; margin: 0 0 0.25rem 0;">Assessments</p>
                            <p style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ $stat['exams'] + $stat['quizzes'] }}</p>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; font-weight: 700; color: #14b8a6; font-size: 0.875rem;">
                        <span>Enter Dashboard</span>
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4-4m4-4H3" /></svg>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; padding: 5rem; text-align: center; background-color: var(--bg-card); border: 1px dashed var(--border-color); border-radius: 2rem;">
                    <p style="color: var(--text-muted); font-style: italic;">No academic sessions available. Please contact administrator.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
