<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - EduManage</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700|poppins:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }

        .sidebar-scrollbar::-webkit-scrollbar { width: 0px; }
        .sidebar-scrollbar:hover::-webkit-scrollbar { width: 4px; }
        .sidebar-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 20px; }
    </style>
</head>
<body class="antialiased bg-[#F8FAFC] text-slate-900 dark:bg-slate-950 dark:text-slate-100 transition-colors duration-300 overflow-x-hidden">
    <div x-data="{ sidebarOpen: window.innerWidth > 1024 }"
         class="flex h-screen overflow-hidden bg-[#F8FAFC] dark:bg-slate-950">

        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 h-full overflow-y-auto overflow-x-hidden relative">

            <!-- Top Navbar -->
            @include('partials.navbar')

            <!-- Main Scrollable Area -->
            <main class="p-6 sm:p-10 lg:p-12 pb-32">
                <div class="max-w-7xl mx-auto">

                    <!-- Unified Notifications -->
                    @if (session('status') || session('success'))
                        <div class="mb-10 p-5 bg-teal-50 border border-teal-100 text-teal-700 rounded-3xl flex items-center gap-4 shadow-sm shadow-teal-50">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-teal-500 shadow-sm">
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
