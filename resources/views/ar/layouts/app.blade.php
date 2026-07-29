<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'EduManage'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,700|almarai:400,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Almarai', sans-serif; }

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

            <!-- Main Page Content -->
            <main class="p-6 sm:p-10 lg:p-12 pb-32">
                <div class="max-w-7xl mx-auto text-right">

                    @if (isset($header))
                        <div class="mb-10">
                            {{ $header }}
                        </div>
                    @elseif(View::hasSection('header'))
                        <div class="mb-10">
                            @yield('header')
                        </div>
                    @endif

                    @if(isset($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
