<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem; max-width: 42rem; margin: 0 auto;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('messages.edit_student') }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">{{ __('messages.modify_student_description') }}: {{ $student->name }}</p>
            </div>

            <a href="{{ route('admin.students.index', ['academicYear' => $academicYear ?? 'primary1']) }}"
               style="padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                {{ __('messages.back_to_list') }}
            </a>
        </div>

        <div class="card-custom">
            <form method="POST" action="{{ route('admin.students.update', $student->code) }}" style="display: flex; flex-direction: column; gap: 1.5rem;">
                @csrf
                @method('PUT')
                <input type="hidden" name="academicYear" value="{{ $academicYear ?? 'primary1' }}">

                <!-- Name -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="name" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.student_name') }}</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $student->name) }}" required autofocus
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;">
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <!-- Code -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="code" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.student_code') }}</label>
                    <input id="code" name="code" type="text" value="{{ old('code', $student->code) }}" required
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem; font-family: monospace;">
                    <x-input-error :messages="$errors->get('code')" />
                </div>

                <!-- Phone -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="phone" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.student_phone') }}</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone', $student->phone) }}"
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;" placeholder="+20...">
                    <x-input-error :messages="$errors->get('phone')" />
                </div>

                <!-- Parent Phone -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="parent_phone" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.parents_phone_number') }}</label>
                    <input id="parent_phone" name="parent_phone" type="tel" value="{{ old('parent_phone', $student->parent_phone) }}"
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;" placeholder="+20...">
                    <x-input-error :messages="$errors->get('parent_phone')" />
                </div>

                <div style="margin-top: 1rem; display: flex; gap: 1rem;">
                    <a href="{{ route('admin.students.index', ['academicYear' => $academicYear ?? 'primary1']) }}"
                        style="flex: 1; padding: 1rem; background-color: var(--bg-alt); color: var(--text-muted); border: 1px solid var(--border-color); border-radius: 1rem; font-weight: 700; font-size: 0.875rem; text-decoration: none; text-align: center; text-transform: uppercase;">
                        {{ __('messages.cancel') }}
                    </a>
                    <button type="submit" style="flex: 2; padding: 1rem; background-color: #f59e0b; color: white; border: none; border-radius: 1rem; font-weight: 800; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.2);">
                        {{ __('messages.update_student_button') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
