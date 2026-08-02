<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem; max-width: 42rem; margin: 0 auto;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">Edit Attendance</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">Updating record for: <span style="font-weight: 700; color: var(--accent-color);">{{ $attendance->student->name }}</span></p>
            </div>

            <a href="{{ route('admin.attendances.index', ['academicYear' => $academicYear ?? 'primary1']) }}"
               style="padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                {{ __('messages.back') }}
            </a>
        </div>

        <div class="card-custom">
            <form method="POST" action="{{ route('admin.attendances.update', $attendance->id) }}" style="display: flex; flex-direction: column; gap: 1.5rem;">
                @csrf
                @method('PUT')
                <input type="hidden" name="academicYear" value="{{ $academicYear ?? 'primary1' }}">

                <!-- Student (Read-only) -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.875rem; font-weight: 700; color: var(--text-muted);">{{ __('messages.student') }}</label>
                    <div style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-muted); font-size: 0.875rem; font-weight: 600;">
                        {{ $attendance->student->name }} ({{ $attendance->student->code }})
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <!-- Date -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <label for="date" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.log_date') }}</label>
                        <input id="date" name="date" type="date" value="{{ old('date', $attendance->date->format('Y-m-d')) }}" required
                               style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;">
                        <x-input-error :messages="$errors->get('date')" />
                    </div>

                    <!-- Status -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <label for="status" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.status') }}</label>
                        <select id="status" name="status" required
                                style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem; cursor: pointer;">
                            <option value="present" {{ old('status', $attendance->status) === 'present' ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ old('status', $attendance->status) === 'absent' ? 'selected' : '' }}>Absent</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" />
                    </div>
                </div>

                <!-- Notes -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="notes" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.internal_notes') }}</label>
                    <textarea id="notes" name="notes" rows="3"
                              style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem; resize: vertical;">{{ old('notes', $attendance->notes) }}</textarea>
                    <x-input-error :messages="$errors->get('notes')" />
                </div>

                <div style="margin-top: 1rem; display: flex; gap: 1rem;">
                    <a href="{{ route('admin.attendances.index', ['academicYear' => $academicYear ?? 'primary1']) }}"
                       style="flex: 1; padding: 1rem; background-color: var(--bg-alt); color: var(--text-muted); border: 1px solid var(--border-color); border-radius: 1rem; font-weight: 700; font-size: 0.875rem; text-decoration: none; text-align: center; text-transform: uppercase;">
                        {{ __('messages.cancel') }}
                    </a>
                    <button type="submit" style="flex: 2; padding: 1rem; background-color: #b5501f; color: white; border: none; border-radius: 1rem; font-weight: 800; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.2);">
                        Update Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
