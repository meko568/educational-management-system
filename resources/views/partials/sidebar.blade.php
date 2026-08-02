<!-- Warm Neutral Sidebar -->
<aside
    :class="sidebarOpen ? 'w-72' : 'w-24'"
    class="hidden lg:flex flex-col flex-none h-full transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] z-30 relative overflow-hidden border-{{ app()->getLocale() === 'ar' ? 'l' : 'r' }}"
    style="background-color: var(--bg-sidebar); color: var(--text-sidebar); border-color: var(--border-color);"
>
    <!-- Sidebar Header -->
    <div :class="sidebarOpen ? 'px-6 py-4 h-16' : 'px-0 py-6 h-auto flex-col'"
         class="flex items-center justify-between flex-none relative z-10 border-b border-white/5 transition-all duration-500">
        <div class="flex items-center gap-3 transition-all duration-500" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100">
            <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, var(--accent-color), #b5501f);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                </svg>
            </div>
            <span class="text-lg font-display font-black tracking-tight uppercase" style="color: var(--text-sidebar);">{{ __('messages.admin_brand') }}</span>
        </div>
        <!-- Placeholder for icon-only logo when closed -->
        <div x-show="!sidebarOpen"
             class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg mx-auto transition-all duration-500 hover:scale-105"
             style="background: linear-gradient(135deg, var(--accent-color), #b5501f); padding: 0.5rem; margin-bottom: 0.75rem;">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
            </svg>
        </div>
        <button @click="sidebarOpen = !sidebarOpen"
                :class="sidebarOpen ? '' : 'mx-auto'"
                class="bg-transparent border-none cursor-pointer p-1.5 flex-shrink-0 opacity-70 hover:opacity-100 transition-opacity" style="color: var(--text-sidebar);">
            <svg class="w-6 h-6 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" :class="sidebarOpen ? '' : 'rotate-180'">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M13 5l7 7-7 7M5 5l7 7-7 7' : 'M11 19l-7-7 7-7m8 14l-7-7 7-7' }}" />
            </svg>
        </button>
    </div>

    <!-- Navigation Section -->
    <nav class="flex-1 px-4 overflow-y-auto overflow-x-hidden sidebar-scrollbar relative z-10 py-6 space-y-1">
        <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
            @php
                $currentYear = $academicYear ?? session('selectedAcademicYear', 'primary1');
                $role = Auth::user()->role;

                if ($role === 'admin') {
                    $navItems = [
                        ['label' => __('messages.dashboard'), 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'route' => 'admin.dashboard'],
                        ['label' => __('messages.students'), 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'route' => 'admin.students.index', 'params' => ['academicYear' => $currentYear]],
                        ['label' => __('messages.courses'), 'icon' => 'M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z', 'route' => 'admin.courses.index', 'params' => ['academicYear' => $currentYear]],
                    ];
                } else {
                    $navItems = [
                        ['label' => __('messages.dashboard'), 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'route' => 'student.dashboard'],
                        ['label' => __('messages.courses'), 'icon' => 'M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z', 'route' => 'student.courses.index'],
                        ['label' => __('messages.my_quizzes'), 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'route' => 'student.quizzes.index'],
                        ['label' => __('messages.my_exams'), 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'route' => 'student.exams.index'],
                    ];
                }
            @endphp

            @foreach($navItems as $item)
                @php $isActive = request()->routeIs($item['route'] . '*'); @endphp
                <a href="{{ Route::has($item['route']) ? route($item['route'], $item['params'] ?? []) : '#' }}"
                   class="group transition-all duration-300"
                   style="{{ $isActive ? 'background-color: var(--text-sidebar); color: #201a12; shadow: 0 4px 6px -1px rgba(0,0,0,0.1);' : 'color: var(--text-sidebar-muted);' }}"
                   :class="sidebarOpen
                        ? 'flex items-center gap-3 px-4 py-3 rounded-xl w-full'
                        : 'flex items-center justify-center w-12 h-12 rounded-2xl mx-auto hover:bg-white/5'">
                    <div class="flex-shrink-0 w-5 h-5 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                        </svg>
                    </div>
                    <span x-show="sidebarOpen"
                          x-transition:enter="transition ease-out duration-300"
                          x-transition:enter-start="opacity-0 -translate-x-2"
                          x-transition:enter-end="opacity-100 translate-x-0"
                          class="font-bold text-sm whitespace-nowrap">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>

        @if($role === 'admin')
        <div class="mt-8 pt-8 border-t border-white/5 space-y-1">
            <p x-show="sidebarOpen"
               class="px-4 text-[10px] font-mono-label font-black uppercase tracking-[0.2em] mb-4 opacity-40" style="color: var(--text-sidebar);">{{ __('messages.academic') }}</p>
            @php
                $academicItems = [
                    ['label' => __('messages.attendance'), 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'route' => 'admin.attendances.index', 'params' => ['academicYear' => $currentYear]],
                    ['label' => __('messages.exams'), 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'route' => 'admin.manual-exams.index', 'params' => ['academicYear' => $currentYear]],
                    ['label' => __('messages.manual_quizzes'), 'icon' => 'M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z', 'route' => 'admin.manual-quizzes.index', 'params' => ['academicYear' => $currentYear]],
                    ['label' => __('messages.auto_exams'), 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'route' => 'admin.exams.index', 'params' => ['academicYear' => $currentYear]],
                    ['label' => __('messages.auto_quizzes'), 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.183.445l-1.676 1.189c-.643.456-1.191.135-1.191-.652V5c0-.787.548-1.108 1.191-.652l1.676 1.189a2 2 0 001.183.445l1.933-.092a6 6 0 013.86.517l.318.158a6 6 0 003.86.517l2.387-.477a2 2 0 011.022.547l.572.572z', 'route' => 'admin.quizzes.index', 'params' => ['academicYear' => $currentYear]],
                    ['label' => __('messages.grade_schedules'), 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'route' => 'admin.schedules.index'],
                    ['label' => __('messages.parents'), 'icon' => 'M17 20h5v-2a4 4 0 00-4-4h-1m-4 6H2v-2a4 4 0 014-4h2m4 6v-2a4 4 0 00-4-4H7m4-6a4 4 0 012-4h2a4 4 0 012 4m-2 6h-2a4 4 0 01-4 4v2a4 4 0 01-4-4H7', 'route' => 'admin.parents.index'],
                ];
            @endphp
            @foreach($academicItems as $item)
                @php $isActive = request()->routeIs($item['route'] . '*'); @endphp
                <a href="{{ Route::has($item['route']) ? route($item['route'], $item['params'] ?? []) : '#' }}"
                   class="group transition-all duration-300"
                   style="{{ $isActive ? 'background-color: var(--text-sidebar); color: #201a12; shadow: 0 4px 6px -1px rgba(0,0,0,0.1);' : 'color: var(--text-sidebar-muted);' }}"
                   :class="sidebarOpen
                        ? 'flex items-center gap-3 px-4 py-3 rounded-xl w-full'
                        : 'flex items-center justify-center w-12 h-12 rounded-2xl mx-auto hover:bg-white/5'">
                    <div class="flex-shrink-0 w-5 h-5 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                        </svg>
                    </div>
                    <span x-show="sidebarOpen"
                          x-transition:enter="transition ease-out duration-300"
                          x-transition:enter-start="opacity-0 -translate-x-2"
                          x-transition:enter-end="opacity-100 translate-x-0"
                          class="font-bold text-sm whitespace-nowrap">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
        @endif
    </nav>

    <!-- Footer Identity -->
    @php
        $yearFull = $academicYear ?? session('selectedAcademicYear', 'primary1');
        $yearShortcut = '';
        if (str_starts_with($yearFull, 'primary')) $yearShortcut = __('messages.shortcut_primary') . substr($yearFull, -1);
        elseif (str_starts_with($yearFull, 'prep')) $yearShortcut = __('messages.shortcut_prep') . substr($yearFull, -1);
        elseif (str_starts_with($yearFull, 'sec')) $yearShortcut = __('messages.shortcut_sec') . substr($yearFull, -1);
        else $yearShortcut = strtoupper(substr($yearFull, 0, 2));
    @endphp
    <div class="p-4 border-t border-white/5 bg-white/2 shadow-inner">
        <div :class="sidebarOpen
                ? 'flex items-center gap-3 p-3 rounded-2xl bg-white/5 border border-white/10 shadow-sm'
                : 'flex items-center justify-center w-12 h-12 rounded-2xl mx-auto bg-white/5 border border-white/10'"
             class="transition-all duration-500">
            <div x-show="sidebarOpen" class="flex-shrink-0 flex items-center justify-center shadow-sm rounded-lg p-1.5" style="background-color: rgba(231, 138, 74, 0.1); color: var(--accent-color);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
            </div>
            <div class="flex items-center font-mono-label font-black uppercase text-xs" x-show="!sidebarOpen" style="color: var(--accent-color);">
                {{ $yearShortcut }}
            </div>
            <div x-show="sidebarOpen" class="transition-all duration-500">
                <p class="text-[8px] font-mono-label font-black uppercase tracking-[0.2em] leading-none mb-1 opacity-40" style="color: var(--text-sidebar);">{{ __('messages.active_grade') }}</p>
                <p class="text-[11px] text-white font-display font-black uppercase leading-none">{{ str_replace('_', ' ', $yearFull) }}</p>
            </div>
        </div>
    </div>
</aside>
