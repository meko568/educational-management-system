<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EduManage - Modern Education Management</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|poppins:600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased bg-[#FBF7EE] dark:bg-stone-950 text-stone-900 dark:text-white transition-colors duration-300">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen"
             x-cloak
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 z-[105] bg-stone-900/60 backdrop-blur-sm lg:hidden"></div>

        @include('partials.sidebar')

        <div class="flex-1 h-full overflow-y-auto overflow-x-hidden relative flex flex-col">
            @include('partials.navbar')

            <!-- Hero Section -->
            <div class="relative min-h-[80vh] flex flex-col items-center justify-center overflow-hidden bg-white dark:bg-stone-950 flex-shrink-0">
        <!-- Abstract Background -->
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-emerald-300 dark:bg-emerald-900 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-orange-300 dark:bg-orange-900 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        </div>

        <!-- Main Content -->
        <main class="relative z-10 max-w-5xl mx-auto px-6 text-center">
            <span class="inline-block px-4 py-1.5 mb-6 text-xs font-black tracking-widest text-emerald-700 dark:text-emerald-400 uppercase bg-emerald-50 dark:bg-emerald-900/30 rounded-full">{{ __('messages.hero_badge') }}</span>
            <h1 class="text-5xl md:text-7xl font-extrabold text-stone-900 dark:text-white leading-tight mb-8">
                {!! __('messages.hero_title') !!}
            </h1>
            <p class="text-xl text-stone-500 dark:text-stone-400 mb-12 max-w-2xl mx-auto leading-relaxed">
                {{ __('messages.hero_subtitle') }}
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-10 py-5 bg-[#1E293B] dark:bg-emerald-600 text-white rounded-3xl font-black text-lg shadow-xl shadow-stone-900/20 transition-all hover:scale-105">
                    {{ __('messages.get_started') }}
                </a>
            </div>
        </main>
    </div>

    <!-- Feature Grid Section -->
    <section id="features" class="py-24 bg-[#FBF7EE] dark:bg-stone-900/50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-black text-stone-900 dark:text-white mb-4">{{ __('messages.features_title') }}</h2>
                <p class="text-stone-500 dark:text-stone-400">{{ __('messages.features_subtitle') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white dark:bg-stone-900 p-8 rounded-3xl shadow-sm border border-stone-100 dark:border-stone-800 hover:border-emerald-500 transition-all group text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                    <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-stone-900 dark:text-white mb-3">{{ __('messages.auto_revision') }}</h3>
                    <p class="text-stone-500 dark:text-stone-400 leading-relaxed text-sm">{{ __('messages.feature_1_desc') }}</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white dark:bg-stone-900 p-8 rounded-3xl shadow-sm border border-stone-100 dark:border-stone-800 hover:border-orange-500 transition-all group text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                    <div class="w-12 h-12 bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-600 group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-stone-900 dark:text-white mb-3">{{ __('messages.realtime_analytics') }}</h3>
                    <p class="text-stone-500 dark:text-stone-400 leading-relaxed text-sm">{{ __('messages.feature_2_desc') }}</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white dark:bg-stone-900 p-8 rounded-3xl shadow-sm border border-stone-100 dark:border-stone-800 hover:border-amber-500 transition-all group text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                    <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-amber-600 group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-stone-900 dark:text-white mb-3">{{ __('messages.user_management') }}</h3>
                    <p class="text-stone-500 dark:text-stone-400 leading-relaxed text-sm">{{ __('messages.feature_3_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white dark:bg-stone-950 border-t border-stone-100 dark:border-stone-900 py-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-sm font-bold text-stone-400 dark:text-stone-600 uppercase tracking-widest">&copy; {{ date('Y') }} EduManage System. All rights reserved.</p>
        </div>
    </footer>
    </div>
    </div>
</body>
</html>
