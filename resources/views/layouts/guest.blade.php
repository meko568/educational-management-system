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
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,700;1,9..144,600&family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    @if(app()->getLocale() === 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @endif

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-display { font-family: 'Fraunces', {{ app()->getLocale() === 'ar' ? "'Noto Sans Arabic', " : '' }}serif; }
        .font-mono-label { font-family: 'JetBrains Mono', monospace; letter-spacing: 0.06em; }
        .hard-shadow { box-shadow: 5px 5px 0 0 #201a12; }

        body {
            font-family: {{ app()->getLocale() === 'ar' ? "'Noto Sans Arabic', 'Inter', sans-serif" : "'Inter', sans-serif" }};
            background-color: #fbf7ee;
            color: #201a12;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center p-6" style="min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1.5rem;">

        <!-- Logo -->
        <div class="mb-8" style="margin-bottom: 2rem;">
            <a href="/" class="flex flex-col items-center gap-4" style="display: flex; flex-direction: column; align-items: center; gap: 1rem; text-decoration: none;">
                <div class="hard-shadow w-16 h-16 rounded-lg flex items-center justify-center" style="width: 4rem; height: 4rem; background-color: #201a12; border: 1.5px solid #201a12; display: flex; align-items: center; justify-content: center; color: #fbf7ee;">
                    <svg class="w-9 h-9" style="width: 2.25rem; height: 2.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <h1 class="font-display text-3xl font-medium tracking-tight" style="color: #201a12; margin: 0;">EduManage</h1>
            </a>
        </div>

        <!-- Lang Toggle -->
        <div class="mb-8 flex items-center gap-4 p-2 rounded-2xl border shadow-sm" style="margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; padding: 0.5rem; border-radius: 1rem; background-color: #fffdf7; border: 1px solid #ded2b5;">
            <div class="flex items-center gap-1" style="display: flex; gap: 0.25rem;">
                <a href="{{ route('lang.switch', 'en') }}" class="px-4 py-2 rounded-lg text-xs font-bold transition-all" style="padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700; text-decoration: none; {{ app()->getLocale() === 'en' ? 'background-color: #b5501f; color: white;' : 'color: #6b6255;' }}">EN</a>
                <a href="{{ route('lang.switch', 'ar') }}" class="px-4 py-2 rounded-lg text-xs font-bold transition-all" style="padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700; text-decoration: none; {{ app()->getLocale() === 'ar' ? 'background-color: #b5501f; color: white;' : 'color: #6b6255;' }}">AR</a>
            </div>
        </div>

        <!-- Auth Card -->
        <div class="hard-shadow w-full sm:max-w-md p-8 sm:p-10 rounded-lg" style="width: 100%; max-width: 28rem; padding: 2.5rem; background-color: #fffdf7; border: 1.5px solid #201a12;">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center" style="margin-top: 2rem; text-align: center;">
            <p class="font-mono-label text-xs font-bold uppercase" style="color: #6b6255;">&copy; {{ date('Y') }} EduManage Platform</p>
        </div>
    </div>
</body>
</html>
