<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem; max-width: 42rem; margin: 0 auto;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ __('messages.add_student') }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">{{ __('messages.onboarding_description') }} {{ strtoupper($academicYear ?? 'primary1') }}</p>
            </div>

            <a href="{{ route('admin.students.index', ['academicYear' => $academicYear ?? 'primary1']) }}"
               style="padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                {{ __('messages.back_to_list') }}
            </a>
        </div>

        <div class="card-custom">
            <form method="POST" action="{{ route('admin.students.store') }}" style="display: flex; flex-direction: column; gap: 1.5rem;">
                @csrf
                <input type="hidden" name="academicYear" value="{{ $academicYear ?? 'primary1' }}">

                <!-- Name -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="name" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.student_name') }}</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;">
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <!-- Phone -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="phone" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.student_phone') }}</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}"
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;" placeholder="+20...">
                    <x-input-error :messages="$errors->get('phone')" />
                </div>

                <!-- Parent Phone -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="parent_phone" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.parents_phone_number') }}</label>
                    <input id="parent_phone" name="parent_phone" type="tel" value="{{ old('parent_phone') }}"
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;" placeholder="+20...">
                    <x-input-error :messages="$errors->get('parent_phone')" />
                </div>

                <div style="margin-top: 1rem;">
                    <button type="submit" style="width: 100%; padding: 1rem; background-color: #0d9488; color: white; border: none; border-radius: 1rem; font-weight: 800; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(13, 148, 136, 0.2);">
                        {{ __('messages.create_student_button') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
