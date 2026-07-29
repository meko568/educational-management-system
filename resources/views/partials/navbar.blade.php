<nav class="w-full sticky top-0 z-[100] backdrop-blur-md" style="width: 100%; background-color: rgba({{ app()->getLocale() === 'ar' ? 'var(--bg-main-rgb, 2, 6, 23)' : 'var(--bg-main-rgb, 255, 255, 255)' }}, 0.9); border-bottom: 1px solid var(--border-color); position: sticky; top: 0; z-index: 100; backdrop-filter: blur(12px); padding: 1rem 1.5rem;">
    <style>
        :root { --bg-main-rgb: 255, 255, 255; }
        .dark { --bg-main-rgb: 2, 6, 23; }
        @media (max-width: 640px) {
            .nav-dashboard-title { display: none; }
        }
    </style>
    <div class="max-w-7xl mx-auto flex items-center justify-between" style="max-width: 1280px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between;">

        <!-- Left Side: Brand & Dashboard Title -->
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <a href="{{ url('/') }}" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none;">
                <div style="width: 2.25rem; height: 2.25rem; background-color: #4f46e5; border-radius: 0.625rem; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                    </svg>
                </div>
                <span style="font-size: 1.25rem; font-weight: 800; color: var(--text-main); letter-spacing: -0.025em;" class="hidden sm:block">EduManage</span>
            </a>

            @auth
                <div style="width: 1px; height: 1.5rem; background-color: var(--border-color);" class="hidden lg:block"></div>
                <div class="nav-dashboard-title">
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('student.dashboard') }}" style="text-decoration: none;">
                        <h2 style="font-size: 1rem; font-weight: 700; color: var(--accent-color); margin: 0; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer;">
                            @if(Auth::user()->role === 'admin')
                                {{ __('messages.admin_dashboard') }}
                            @elseif(Auth::user()->role === 'student')
                                {{ __('messages.student_dashboard_title') }}
                            @else
                                {{ __('messages.dashboard') }}
                            @endif
                        </h2>
                    </a>
                </div>
            @endauth
        </div>

        <!-- Right Side: Actions -->
        <div style="display: flex; align-items: center; gap: 1rem;">

            <!-- Theme Toggle -->
            <div x-data="{
                theme: localStorage.getItem('theme') || 'system',
                setTheme(val) {
                    this.theme = val;
                    window.setTheme(val);
                }
            }" style="display: flex; background-color: var(--border-color); padding: 0.25rem; border-radius: 0.5rem;">
                <button @click="setTheme('light')" :class="theme === 'light' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-400'" style="padding: 0.25rem; border-radius: 0.375rem; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; {{ app()->getLocale() === 'ar' ? 'margin-left: 2px;' : 'margin-right: 2px;' }}">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m12.728 12.728L5.99 5.99" /></svg>
                </button>
                <button @click="setTheme('dark')" :class="theme === 'dark' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-400'" style="padding: 0.25rem; border-radius: 0.375rem; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                </button>
            </div>

            <!-- Language Switcher -->
            <div style="display: flex; background-color: var(--border-color); padding: 0.25rem; border-radius: 0.5rem;">
                <a href="{{ route('lang.switch', 'en') }}" style="padding: 0.25rem 0.75rem; border-radius: 0.375rem; font-size: 0.625rem; font-weight: 700; text-transform: uppercase; text-decoration: none; transition: all 0.2s; {{ app()->getLocale() === 'en' ? 'background-color: var(--bg-card); color: #4f46e5; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' : 'color: var(--text-muted);' }}">EN</a>
                <a href="{{ route('lang.switch', 'ar') }}" style="padding: 0.25rem 0.75rem; border-radius: 0.375rem; font-size: 0.625rem; font-weight: 700; text-transform: uppercase; text-decoration: none; transition: all 0.2s; {{ app()->getLocale() === 'ar' ? 'background-color: var(--bg-card); color: #4f46e5; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' : 'color: var(--text-muted);' }}">AR</a>
            </div>

            @auth
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div class="hidden md:block" style="text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">
                        <p style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); text-transform: uppercase; margin: 0;">{{ Auth::user()->name }}</p>
                        <p style="font-size: 0.625rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0.125rem 0 0 0;">{{ Auth::user()->role }}</p>
                    </div>

                    <a href="{{ route('profile.edit') }}" style="width: 2.5rem; height: 2.5rem; border-radius: 9999px; background-color: var(--bg-alt); display: flex; align-items: center; justify-content: center; color: var(--text-muted); border: 1px solid var(--border-color); text-decoration: none;">
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="padding: 0.5rem 1rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; cursor: pointer;">
                            {{ __('messages.log_out') }}
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" style="padding: 0.625rem 1.5rem; background-color: #4f46e5; color: white; border-radius: 0.5rem; font-weight: 700; font-size: 0.875rem; text-decoration: none; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1);">
                    {{ __('messages.login') }}
                </a>
            @endauth
        </div>
    </div>
</nav>
