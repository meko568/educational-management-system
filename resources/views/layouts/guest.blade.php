<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EduManage') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @if(app()->getLocale() === 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @endif

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-main: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #475569;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
        }

        .dark {
            --bg-main: #020617;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --card-bg: #0f172a;
            --border-color: #1e293b;
        }

        body {
            font-family: {{ app()->getLocale() === 'ar' ? "'Noto Sans Arabic', 'Inter', sans-serif" : "'Inter', sans-serif" }};
            background-color: var(--bg-main);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center p-6" style="min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1.5rem;">

        <!-- Logo -->
        <div class="mb-8" style="margin-bottom: 2rem;">
            <a href="/" class="flex flex-col items-center gap-4" style="display: flex; flex-direction: column; align-items: center; gap: 1rem; text-decoration: none;">
                <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-xl" style="width: 4rem; height: 4rem; background-color: #4f46e5; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);">
                    <svg class="w-10 h-10" style="width: 2.5rem; height: 2.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight" style="font-size: 1.875rem; font-weight: 800; color: var(--text-main); margin: 0;">EduManage</h1>
            </a>
        </div>

        <!-- Theme/Lang Toggle -->
        <div class="mb-8 flex items-center gap-4 p-2 rounded-2xl border shadow-sm" style="margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; padding: 0.5rem; border-radius: 1rem; background-color: var(--card-bg); border: 1px solid var(--border-color);">
            <div class="flex items-center gap-1" style="display: flex; gap: 0.25rem;">
                <a href="{{ route('lang.switch', 'en') }}" class="px-4 py-2 rounded-lg text-xs font-bold transition-all" style="padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700; text-decoration: none; {{ app()->getLocale() === 'en' ? 'background-color: #4f46e5; color: white;' : 'color: var(--text-muted);' }}">EN</a>
                <a href="{{ route('lang.switch', 'ar') }}" class="px-4 py-2 rounded-lg text-xs font-bold transition-all" style="padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700; text-decoration: none; {{ app()->getLocale() === 'ar' ? 'background-color: #4f46e5; color: white;' : 'color: var(--text-muted);' }}">AR</a>
            </div>

            <div style="width: 1px; height: 1.5rem; background-color: var(--border-color);"></div>

            <div x-data="{ theme: localStorage.getItem('theme') || 'system' }" class="flex items-center gap-1" style="display: flex; gap: 0.25rem;">
                <button @click="window.setTheme('light'); theme = 'light'" class="p-2 rounded-lg transition-all" style="border: none; cursor: pointer; background: transparent; color: var(--text-muted);">
                    <svg class="w-4 h-4" style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m12.728 12.728L5.99 5.99" /></svg>
                </button>
                <button @click="window.setTheme('dark'); theme = 'dark'" class="p-2 rounded-lg transition-all" style="border: none; cursor: pointer; background: transparent; color: var(--text-muted);">
                    <svg class="w-4 h-4" style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                </button>
            </div>
        </div>

        <!-- Auth Card -->
        <div class="w-full sm:max-w-md p-8 sm:p-10 rounded-[2rem] border shadow-xl" style="width: 100%; max-width: 28rem; padding: 2.5rem; border-radius: 2rem; background-color: var(--card-bg); border: 1px solid var(--border-color); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center" style="margin-top: 2rem; text-align: center;">
            <p class="text-xs font-bold uppercase tracking-widest" style="font-size: 0.75rem; color: var(--text-muted); letter-spacing: 0.1em;">&copy; {{ date('Y') }} EduManage Platform</p>
        </div>
    </div>
</body>
</html>
