<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem; max-width: 48rem; margin: 0 auto;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">Create Auto-Revision Exam</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">Digital assessment for <span style="font-weight: 700; color: var(--accent-color);">{{ strtoupper($selectedGrade) }}</span></p>
            </div>

            <a href="{{ route('admin.exams.index') }}"
               style="padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                {{ __('messages.cancel') }}
            </a>
        </div>

        <div class="card-custom">
            <form method="POST" action="{{ route('admin.exams.store', ['grade' => $selectedGrade]) }}" style="display: flex; flex-direction: column; gap: 2rem;">
                @csrf

                <!-- Title -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="title" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Exam Title</label>
                    <input id="title" name="title" type="text" value="{{ old('title') }}" required autofocus
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;">
                    <x-input-error :messages="$errors->get('title')" />
                </div>

                <!-- Description -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="description" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Description (Optional)</label>
                    <textarea id="description" name="description" rows="3"
                              style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem; resize: vertical;">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                <!-- Date Selection -->
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <label style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Select Scheduled Day</label>

                    @if(!empty($suggestedDates))
                        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                            @foreach($suggestedDates as $suggested)
                                <label class="suggested-date-pill" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border-color); background-color: var(--bg-alt); cursor: pointer; transition: all 0.2s;">
                                    <input type="radio" name="base_date" value="{{ $suggested['date'] }}" style="display: none;" onchange="updateDates(this.value)">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted);">{{ $suggested['label'] }}</span>
                                </label>
                            @endforeach
                            <!-- Custom Date Pill -->
                            <label class="suggested-date-pill custom-date-pill" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border-color); background-color: var(--bg-alt); cursor: pointer; transition: all 0.2s;">
                                <input type="radio" name="base_date" value="custom" style="display: none;" onchange="updateDates('custom')">
                                <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted);">Custom Date</span>
                            </label>
                        </div>
                    @endif

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div>
                            <span style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase;">Start Time:</span>
                            <input id="start_datetime" name="start_datetime" type="datetime-local" required
                                   style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;">
                        </div>
                        <div>
                            <span style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase;">Expiry Time (Default 2 Days):</span>
                            <input id="end_datetime" name="end_datetime" type="datetime-local" required
                                   style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;">
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('start_datetime')" />
                    <x-input-error :messages="$errors->get('end_datetime')" />
                </div>

                <!-- Duration -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="duration_minutes" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Duration (Minutes)</label>
                    <input id="duration_minutes" name="duration_minutes" type="number" value="{{ old('duration_minutes', 60) }}" min="1" required
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;">
                    <x-input-error :messages="$errors->get('duration_minutes')" />
                </div>

                <div style="margin-top: 1rem;">
                    <button type="submit" style="width: 100%; padding: 1rem; background-color: #db2777; color: white; border: none; border-radius: 1rem; font-weight: 800; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(219, 39, 119, 0.2);">
                        Create Exam & Add Questions
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Set default start time to now
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('start_datetime').value = now.toISOString().slice(0, 16);

        function updateDates(baseDate) {
            // Update pills UI
            document.querySelectorAll('.suggested-date-pill').forEach(l => {
                l.style.backgroundColor = 'var(--bg-alt)';
                l.querySelector('span').style.color = 'var(--text-muted)';
            });
            const activeLabel = event.target.closest('label');
            activeLabel.style.backgroundColor = 'rgba(219, 39, 119, 0.1)';
            activeLabel.querySelector('span').style.color = '#db2777';

            if (baseDate === 'custom') {
                document.getElementById('start_datetime').focus();
                document.getElementById('start_datetime').showPicker();
                return;
            }

            // Calculate start: base date + current hour/min
            const start = new Date(baseDate);
            const current = new Date();
            start.setHours(current.getHours(), current.getMinutes(), 0);

            // Calculate end: base date + 1 day + 23:59:59
            const end = new Date(baseDate);
            end.setDate(end.getDate() + 1);
            end.setHours(23, 59, 59);

            // Format for datetime-local
            const format = (d) => {
                d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
                return d.toISOString().slice(0, 16);
            };

            document.getElementById('start_datetime').value = format(start);
            document.getElementById('end_datetime').value = format(end);
        }
    </script>
    @endpush
</x-app-layout>
