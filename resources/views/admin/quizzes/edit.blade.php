<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem; max-width: 42rem; margin: 0 auto;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">Edit Manual Quiz</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">Modify assessment record: <span style="font-weight: 700; color: #ea580c;">{{ $quiz->title }}</span></p>
            </div>

            <a href="{{ route('admin.manual-quizzes.index', ['academicYear' => $academicYear ?? 'primary1']) }}"
               style="padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                {{ __('messages.back') }}
            </a>
        </div>

        <div class="card-custom">
            <form method="POST" action="{{ route('admin.manual-quizzes.update', $quiz->id) }}" style="display: flex; flex-direction: column; gap: 1.5rem;">
                @csrf
                @method('PUT')
                <input type="hidden" name="academicYear" value="{{ $academicYear ?? 'primary1' }}">

                <!-- Title -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="title" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Quiz Title</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $quiz->title) }}" required autofocus
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;">
                    <x-input-error :messages="$errors->get('title')" />
                </div>

                <!-- Description -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="description" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Description (Optional)</label>
                    <textarea id="description" name="description" rows="3"
                              style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem; resize: vertical;">{{ old('description', $quiz->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                <!-- Exam Selection -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="exam_id" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Exam (Optional)</label>
                    <select id="exam_id" name="exam_id"
                            style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem; cursor: pointer;">
                        <option value="">-- Select an Exam --</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}" {{ old('exam_id', $quiz->exam_id) == $exam->id ? 'selected' : '' }}>
                                {{ $exam->title }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('exam_id')" />
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <!-- Total Marks -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <label for="total_marks" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Maximum Score</label>
                        <input id="total_marks" name="total_marks" type="number" value="{{ old('total_marks', $quiz->total_marks) }}" required
                               style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;">
                        <x-input-error :messages="$errors->get('total_marks')" />
                    </div>

                    <!-- Status -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <label for="status" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Status</label>
                        <select id="status" name="status"
                                style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem; cursor: pointer;">
                            <option value="draft" {{ old('status', $quiz->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $quiz->status) === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status', $quiz->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" />
                    </div>
                </div>

                <div style="margin-top: 1rem; display: flex; gap: 1rem;">
                    <a href="{{ route('admin.manual-quizzes.index', ['academicYear' => $academicYear ?? 'primary1']) }}"
                       style="flex: 1; padding: 1rem; background-color: var(--bg-alt); color: var(--text-muted); border: 1px solid var(--border-color); border-radius: 1rem; font-weight: 700; font-size: 0.875rem; text-decoration: none; text-align: center; text-transform: uppercase;">
                        {{ __('messages.cancel') }}
                    </a>
                    <button type="submit" style="flex: 2; padding: 1rem; background-color: #f59e0b; color: white; border: none; border-radius: 1rem; font-weight: 800; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.2);">
                        Update Quiz Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
