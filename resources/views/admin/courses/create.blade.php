<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem; max-width: 42rem; margin: 0 auto;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">Create New Course</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">Add a new curriculum entry for {{ strtoupper($academicYear) }}</p>
            </div>

            <a href="{{ route('admin.courses.index', $academicYear) }}"
               style="padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                {{ __('messages.back') }}
            </a>
        </div>

        <div class="card-custom">
            <form method="POST" action="{{ route('admin.courses.store', $academicYear) }}" style="display: flex; flex-direction: column; gap: 1.5rem;">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <!-- Month Selection -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <label for="month" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Target Month</label>
                        <select id="month" name="month" required
                                style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem; cursor: pointer;">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ date('n') == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Year Selection -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <label for="year" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Target Year</label>
                        <input id="year" name="year" type="number" value="{{ date('Y') }}" required
                               style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;">
                    </div>
                </div>

                <!-- Course Code -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="code" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.course_code') }}</label>
                    <input id="code" name="code" type="text" value="{{ old('code') }}" required
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem; font-family: monospace;" placeholder="e.g., MATH-101-OCT">
                    <x-input-error :messages="$errors->get('code')" />
                </div>

                <!-- Course Name -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="name" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.course_name') }}</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;" placeholder="Course Title">
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <!-- Description -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="description" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Description (Optional)</label>
                    <textarea id="description" name="description" rows="4"
                              style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem; resize: vertical;" placeholder="Overview of what students will learn...">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                <div style="margin-top: 1rem;">
                    <button type="submit" style="width: 100%; padding: 1rem; background-color: #7c3aed; color: white; border: none; border-radius: 1rem; font-weight: 800; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(124, 58, 237, 0.2);">
                        Create Monthly Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
