<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('messages.mark_attendance_title') }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">{{ __('messages.grade') }}: {{ strtoupper($academicYear) }} • {{ now()->format('l, M d, Y') }}</p>
            </div>

            <a href="{{ route('admin.attendances.index', ['academicYear' => $academicYear]) }}"
               style="padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                {{ __('messages.back') }}
            </a>
        </div>

        <!-- Search & Date Selection -->
        <div class="card-custom" style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;" class="md:grid-cols-2">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted);">{{ __('messages.select_date') }}</label>
                    <input type="date" id="attendance_date" value="{{ date('Y-m-d') }}"
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted);">{{ __('messages.search_student') }}</label>
                    <input type="text" id="student_search" placeholder="{{ __('messages.type_name_or_code') }}"
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;">
                </div>
            </div>
        </div>

        <!-- Students Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;" id="students_grid">
            @foreach($students as $student)
                @php
                    $dayName = date('l');
                    $gradeDays = $schedules->days ?? [];
                    $isScheduled = in_array($dayName, $gradeDays);
                @endphp
                <div class="card-custom student-card"
                     data-name="{{ strtolower($student->name) }}"
                     data-code="{{ $student->code }}"
                     onclick="markAttendance('{{ $student->code }}', 'present')"
                     style="display: flex; flex-direction: column; gap: 1rem; cursor: pointer; transition: all 0.2s; position: relative; border: 2px solid transparent;">

                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 2.5rem; height: 2.5rem; border-radius: 9999px; background-color: var(--bg-alt); border: 1px solid var(--border-color); color: var(--text-main); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem;">
                            {{ substr($student->name, 0, 1) }}
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; color: var(--text-main);">{{ $student->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted); font-family: monospace;">{{ $student->code }}</div>
                        </div>
                        @if($isScheduled)
                            <div title="Scheduled Day" style="width: 0.5rem; height: 0.5rem; background-color: #10b981; border-radius: 9999px;"></div>
                        @endif
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 0.75rem; border-top: 1px solid var(--border-color);">
                        <span style="font-size: 0.625rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">{{ __('messages.click_to_mark_present') }}</span>
                        <button onclick="event.stopPropagation(); markAttendance('{{ $student->code }}', 'absent')"
                                style="background-color: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; padding: 0.25rem 0.5rem; border-radius: 0.375rem; font-size: 0.625rem; font-weight: 800; cursor: pointer; text-transform: uppercase;">
                            {{ __('messages.mark_absent') }}
                        </button>
                    </div>

                    <!-- Status Overlay (Initially Hidden) -->
                    <div class="status-indicator" style="display: none; position: absolute; top: 0.5rem; right: 0.5rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase;"></div>
                </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
    <script>
        const searchInput = document.getElementById('student_search');
        const cards = document.querySelectorAll('.student-card');

        searchInput.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            cards.forEach(card => {
                const name = card.dataset.name;
                const code = card.dataset.code;
                card.style.display = (name.includes(term) || code.includes(term)) ? 'flex' : 'none';
            });
        });

        function markAttendance(studentCode, status) {
            const date = document.getElementById('attendance_date').value;
            const academicYear = '{{ $academicYear }}';
            const card = document.querySelector(`.student-card[data-code="${studentCode}"]`);

            fetch('{{ route("admin.attendances.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    student_code: studentCode,
                    date: date,
                    status: status,
                    academicYear: academicYear
                })
            })
            .then(async response => {
                const data = await response.json();
                if (response.ok) {
                    const indicator = card.querySelector('.status-indicator');
                    indicator.style.display = 'block';
                    if(status === 'present') {
                        card.style.borderColor = '#10b981';
                        card.style.backgroundColor = 'rgba(16, 185, 129, 0.05)';
                        indicator.innerText = '{{ __("messages.present_check") }}';
                        indicator.style.color = '#10b981';
                    } else {
                        card.style.borderColor = '#ef4444';
                        card.style.backgroundColor = 'rgba(239, 68, 68, 0.05)';
                        indicator.innerText = '{{ __("messages.absent_check") }}';
                        indicator.style.color = '#ef4444';
                    }
                } else {
                    alert(data.message || 'Error marking attendance');
                }
            })
            .catch(err => alert('Network error'));
        }
    </script>
    @endpush
</x-app-layout>
