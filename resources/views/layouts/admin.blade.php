<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', __('messages.admin_dashboard')) - EduManage</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,700;1,9..144,600&family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet" />
    @if(app()->getLocale() === 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @endif

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        html {
            scroll-behavior: smooth;
        }
        body { font-family: {{ app()->getLocale() === 'ar' ? "'Noto Sans Arabic', 'Inter', sans-serif" : "'Inter', sans-serif" }}; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Fraunces', {{ app()->getLocale() === 'ar' ? "'Noto Sans Arabic', " : '' }}serif; font-weight: 600; }
        .dashboard-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
            background-color: var(--bg-main);
        }

        .main-content {
            flex: 1;
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
            position: relative;
            display: flex;
            flex-direction: column;
            scroll-behavior: smooth;
        }

        .sidebar-scrollbar::-webkit-scrollbar { width: 4px; }
        .sidebar-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 20px; }
    </style>
</head>
<body class="antialiased bg-[#FBF7EE] text-stone-900 dark:bg-stone-950 dark:text-stone-100 transition-colors duration-300 overflow-x-hidden">
    <div x-data="{ sidebarOpen: window.innerWidth > 1024 }"
         class="dashboard-container flex h-screen overflow-hidden bg-[#FBF7EE] dark:bg-stone-950">

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

        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content Area -->
        <div class="main-content flex-1 h-full overflow-y-auto overflow-x-hidden relative">
            <!-- Top Navbar -->
            @include('partials.navbar')

            <!-- Main Scrollable Area -->
            <main class="p-6 sm:p-10 lg:p-12 pb-32">
                <div class="max-w-7xl mx-auto">

                    <!-- Unified Notifications -->
                    @if (session('status') || session('success'))
                        <div class="mb-10 p-5 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-lg flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-md flex items-center justify-center text-emerald-500 border border-emerald-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="text-sm font-black uppercase tracking-tight">{{ session('status') ?? session('success') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
