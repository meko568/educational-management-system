<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem; max-width: 48rem; margin: 0 auto;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">Create New Lesson</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">Adding to: <span style="font-weight: 700; color: var(--accent-color);">{{ $course->name }}</span> ({{ date('F Y', mktime(0, 0, 0, $course->month, 1, $course->year)) }})</p>
            </div>

            <a href="{{ route('admin.courses.show', [$academicYear, $course]) }}"
               style="padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                {{ __('messages.back') }}
            </a>
        </div>

        <div class="card-custom">
            <form method="POST" action="{{ route('admin.courses.lessons.store', [$academicYear, $course]) }}" style="display: flex; flex-direction: column; gap: 2rem;">
                @csrf

                <!-- Scheduled Release Date -->
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <label style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Scheduled Release Date</label>

                    @if(!empty($suggestedDates))
                        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 0.5rem;">
                            @foreach($suggestedDates as $suggested)
                                <label class="suggested-date-label" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border-color); background-color: var(--bg-alt); cursor: pointer; transition: all 0.2s;">
                                    <input type="radio" name="scheduled_date_suggested" value="{{ $suggested['date'] }}" style="display: none;" onchange="document.getElementById('scheduled_date').value = this.value">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted);">{{ $suggested['label'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif

                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <span style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase;">Or select custom date:</span>
                        <input id="scheduled_date" name="scheduled_date" type="date" required
                               min="{{ sprintf('%04d-%02d-01', $course->year, $course->month) }}"
                               max="{{ date('Y-m-t', strtotime(sprintf('%04d-%02d-01', $course->year, $course->month))) }}"
                               value="{{ old('scheduled_date') }}"
                               style="width: 100%; padding: 0.75rem 1rem; background-color: rgba(79, 70, 229, 0.05); border: 1px solid var(--accent-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;">
                    </div>
                    <x-input-error :messages="$errors->get('scheduled_date')" />
                </div>

                <!-- Title -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="title" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Lesson Title</label>
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

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <!-- Video URL -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <label for="video_url" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Video URL</label>
                        <input id="video_url" name="video_url" type="url" value="{{ old('video_url') }}"
                               style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;" placeholder="YouTube or direct link">
                        <x-input-error :messages="$errors->get('video_url')" />
                    </div>

                    <!-- PDF URL -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <label for="pdf_url" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">PDF Material URL</label>
                        <input id="pdf_url" name="pdf_url" type="url" value="{{ old('pdf_url') }}"
                               style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;" placeholder="Link to study notes">
                        <x-input-error :messages="$errors->get('pdf_url')" />
                    </div>
                </div>

                <!-- Order -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="order" style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">Lesson Order</label>
                    <input id="order" name="order" type="number" value="{{ old('order', 0) }}" min="0" required
                           style="width: 100%; padding: 0.75rem 1rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-main); font-size: 0.875rem;">
                    <x-input-error :messages="$errors->get('order')" />
                </div>

                <div style="margin-top: 1rem;">
                    <button type="submit" style="width: 100%; padding: 1rem; background-color: #10b981; color: white; border: none; border-radius: 1rem; font-weight: 800; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);">
                        Publish Lesson
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.querySelectorAll('.suggested-date-label').forEach(label => {
            label.addEventListener('click', () => {
                document.querySelectorAll('.suggested-date-label').forEach(l => {
                    l.style.backgroundColor = 'var(--bg-alt)';
                    l.querySelector('span').style.color = 'var(--text-muted)';
                });
                label.style.backgroundColor = 'rgba(79, 70, 229, 0.1)';
                label.querySelector('span').style.color = '#b5501f';
            });
        });
    </script>
    @endpush
</x-app-layout>
