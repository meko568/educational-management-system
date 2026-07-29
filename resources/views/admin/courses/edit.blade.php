<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem; max-width: 42rem; margin: 0 auto;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">Edit Course</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">Modify curriculum entry: {{ $course->name }}</p>
            </div>

            <a href="{{ route('admin.courses.index', $academicYear) }}"
               style="padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                {{ __('messages.back') }}
            </a>
        </div>

        <div class="card-custom">
            <form method="POST" action="{{ route('admin.courses.update', [$academicYear, $course]) }}" style="display: flex; flex-direction: column; gap: 1.5rem;">
                @csrf
                @method('PUT')

                <!-- Course Code -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="code" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.course_code') }}</label>
                    <input id="code" name="code" type="text" value="{{ old('code', $course->code) }}" required autofocus
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem; font-family: monospace;">
                    <x-input-error :messages="$errors->get('code')" />
                </div>

                <!-- Course Name -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="name" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.course_name') }}</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $course->name) }}" required
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;">
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <!-- Description -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="description" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Description (Optional)</label>
                    <textarea id="description" name="description" rows="4"
                              style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem; resize: vertical;">{{ old('description', $course->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                <div style="margin-top: 1rem; display: flex; gap: 1rem;">
                    <a href="{{ route('admin.courses.index', $academicYear) }}"
                       style="flex: 1; padding: 1rem; background-color: var(--bg-alt); color: var(--text-muted); border: 1px solid var(--border-color); border-radius: 1rem; font-weight: 700; font-size: 0.875rem; text-decoration: none; text-align: center; text-transform: uppercase;">
                        {{ __('messages.cancel') }}
                    </a>
                    <button type="submit" style="flex: 2; padding: 1rem; background-color: #f59e0b; color: white; border: none; border-radius: 1rem; font-weight: 800; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.2);">
                        Update Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
