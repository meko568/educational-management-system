<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">Grade Schedules</h1>
            <p style="color: var(--text-muted); margin: 0;">Define attending days for each academic year</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
            @foreach($grades as $grade)
                <div class="card-custom">
                    <form method="POST" action="{{ route('admin.schedules.update') }}" style="display: flex; flex-direction: column; gap: 1.5rem;">
                        @csrf
                        <input type="hidden" name="grade" value="{{ $grade }}">

                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 2.5rem; height: 2.5rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); color: var(--accent-color); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); margin: 0; text-transform: uppercase;">{{ str_replace('_', ' ', $grade) }}</h3>
                        </div>

                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                            @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                @php
                                    $isSelected = isset($schedules[$grade]) && in_array($day, $schedules[$grade]->days);
                                @endphp
                                <label style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border-color); cursor: pointer; background-color: {{ $isSelected ? 'rgba(79, 70, 229, 0.1)' : 'var(--bg-alt)' }}; transition: all 0.2s;">
                                    <input type="checkbox" name="days[]" value="{{ $day }}" {{ $isSelected ? 'checked' : '' }} style="display: none;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: {{ $isSelected ? '#b5501f' : 'var(--text-muted)' }};">{{ $day }}</span>
                                </label>
                            @endforeach
                        </div>

                        <button type="submit" style="padding: 0.75rem; background-color: var(--accent-color); color: white; border: none; border-radius: 0.75rem; font-weight: 700; cursor: pointer; transition: opacity 0.2s;">
                            Update Days
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
    <script>
        document.querySelectorAll('label').forEach(label => {
            const checkbox = label.querySelector('input[type="checkbox"]');
            if(checkbox) {
                checkbox.addEventListener('change', () => {
                    if(checkbox.checked) {
                        label.style.backgroundColor = 'rgba(79, 70, 229, 0.1)';
                        label.querySelector('span').style.color = '#b5501f';
                    } else {
                        label.style.backgroundColor = 'var(--bg-alt)';
                        label.querySelector('span').style.color = 'var(--text-muted)';
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
