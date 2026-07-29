<!-- Modern Neo-Sidebar -->
<aside
    :class="sidebarOpen ? 'w-72' : 'w-24'"
    class="hidden lg:flex flex-col flex-none h-full transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] z-30 relative overflow-hidden"
    style="background-color: var(--bg-sidebar); color: white; border-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: 1px solid var(--border-color); width: 18rem;"
>
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between px-7 py-8 h-24 flex-none relative z-10" style="padding: 2rem 1.75rem; height: 6rem; display: flex; align-items: center; justify-content: space-between;">
        <div class="flex items-center gap-4 transition-all duration-500" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 scale-50 w-0 overflow-hidden'" style="display: flex; align-items: center; gap: 1rem;">
            <div class="flex-shrink-0 w-10 h-10 rounded-2xl flex items-center justify-center shadow-lg" style="width: 2.5rem; height: 2.5rem; background: linear-gradient(to top right, #2dd4bf, #0d9488); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                <svg class="w-6 h-6 text-white" style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                </svg>
            </div>
            <span class="text-xl font-black tracking-tighter uppercase" style="font-size: 1.25rem; font-weight: 900; letter-spacing: -0.05em; text-transform: uppercase;">EduAdmin</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen"
                style="background: transparent; border: none; cursor: pointer; color: var(--sidebar-text); padding: 0.5rem;">
            <svg class="w-6 h-6" style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" :class="sidebarOpen ? '' : 'rotate-180'">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M13 5l7 7-7 7M5 5l7 7-7 7' : 'M11 19l-7-7 7-7m8 14l-7-7 7-7' }}" />
            </svg>
        </button>
    </div>

    <!-- Navigation Section -->
    <nav class="flex-1 px-4 overflow-y-auto sidebar-scrollbar relative z-10" style="flex: 1; padding: 1.5rem 1rem; overflow-y: auto;">
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            @php
                $currentYear = $academicYear ?? 'primary1';
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
                   style="display: flex; align-items: center; gap: 1.25rem; padding: 0.875rem 1rem; border-radius: 1rem; text-decoration: none; transition: all 0.3s; {{ $isActive ? 'background-color: white; color: #0f172a;' : 'color: var(--sidebar-text);' }}"
                   class="group">
                    <div style="flex-shrink: 0; width: 1.5rem; display: flex; justify-content: center;">
                        <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                        </svg>
                    </div>
                    <span style="font-weight: 700; font-size: 0.875rem; white-space: nowrap;">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>

        @if($role === 'admin')
        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05); display: flex; flex-direction: column; gap: 0.5rem;">
            <p style="padding: 0 1rem; font-size: 0.625rem; font-weight: 900; color: #475569; text-transform: uppercase; letter-spacing: 0.3em; margin-bottom: 1rem;">{{ __('messages.academic') }}</p>
            @php
                $academicItems = [
                    ['label' => __('messages.attendance'), 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'route' => 'admin.attendances.index', 'params' => ['academicYear' => $currentYear]],
                    ['label' => __('messages.exams'), 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'route' => 'admin.manual-exams.index', 'params' => ['academicYear' => $currentYear]],
                    ['label' => __('messages.auto_revision'), 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'route' => 'admin.exams.index'],
                    ['label' => 'Grade Schedules', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'route' => 'admin.schedules.index'],
                    ['label' => __('messages.parents'), 'icon' => 'M17 20h5v-2a4 4 0 00-4-4h-1m-4 6H2v-2a4 4 0 014-4h2m4 6v-2a4 4 0 00-4-4H7m4-6a4 4 0 012-4h2a4 4 0 012 4m-2 6h-2a4 4 0 01-4 4v2a4 4 0 01-4-4H7', 'route' => 'admin.parents.index'],
                ];
            @endphp
            @foreach($academicItems as $item)
                @php $isActive = request()->routeIs($item['route'] . '*'); @endphp
                <a href="{{ Route::has($item['route']) ? route($item['route'], $item['params'] ?? []) : '#' }}"
                   style="display: flex; align-items: center; gap: 1.25rem; padding: 0.875rem 1rem; border-radius: 1rem; text-decoration: none; transition: all 0.3s; {{ $isActive ? 'background-color: white; color: #0f172a;' : 'color: var(--sidebar-text);' }}"
                   class="group">
                    <div style="flex-shrink: 0; width: 1.5rem; display: flex; justify-content: center;">
                        <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                        </svg>
                    </div>
                    <span style="font-weight: 700; font-size: 0.875rem; white-space: nowrap;">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
        @endif
    </nav>

    <!-- Footer Identity -->
    <div style="padding: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05); background-color: rgba(255,255,255,0.02);">
        <div style="padding: 1rem; border-radius: 1.25rem; background-color: rgba(255,255,255,0.05); display: flex; align-items: center; gap: 1rem; border: 1px solid rgba(255,255,255,0.1);">
            <div style="flex-shrink: 0; color: #2dd4bf;">
                <svg style="width: 1.75rem; height: 1.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
            </div>
            <div>
                <p style="font-size: 0.5625rem; font-weight: 900; text-transform: uppercase; color: #475569; letter-spacing: 0.2em; margin: 0;">{{ __('messages.active_grade') }}</p>
                <p style="font-size: 0.875rem; color: #e2e8f0; font-weight: 900; text-transform: uppercase; margin: 0.25rem 0 0 0;">{{ str_replace('_', ' ', $academicYear ?? 'primary1') }}</p>
            </div>
        </div>
    </div>
</aside>
