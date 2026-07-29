<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EduManage') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,700|almarai:400,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Almarai', sans-serif; }
    </style>
</head>
<body class="antialiased bg-[#F8FAFC] dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-300">
    <div class="min-h-screen flex flex-col items-center justify-center p-6">
        <!-- Logo -->
        <div class="mb-10">
            <a href="/" class="flex flex-col items-center gap-4 group">
                <div class="w-16 h-16 bg-[#1E293B] dark:bg-teal-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-slate-900/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-[#1E293B] dark:text-white">EduManage</h1>
            </a>
        </div>

        <!-- Theme/Lang Toggle for Guest -->
        <div class="mb-6 flex items-center gap-4 bg-white dark:bg-slate-900 p-2 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
             <div class="flex items-center gap-1">
                <a href="{{ route('lang.switch', 'en') }}" class="px-3 py-1.5 rounded-lg text-[10px] font-black transition-all {{ app()->getLocale() === 'en' ? 'bg-teal-600 text-white' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">EN</a>
                <a href="{{ route('lang.switch', 'ar') }}" class="px-3 py-1.5 rounded-lg text-[10px] font-black transition-all {{ app()->getLocale() === 'ar' ? 'bg-teal-600 text-white' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">AR</a>
            </div>
        </div>

        <!-- Auth Card -->
        <div class="w-full sm:max-w-md bg-white dark:bg-slate-900 p-8 sm:p-10 rounded-[2.5rem] shadow-2xl shadow-slate-200/60 dark:shadow-none border border-slate-100 dark:border-slate-800">
            {{ $slot }}
        </div>

        <!-- Help Link -->
        <div class="mt-8 text-center">
            <p class="text-sm text-slate-400 font-bold uppercase tracking-widest">&copy; {{ date('Y') }} EduManage Platform</p>
        </div>
    </div>
</body>
</html>
