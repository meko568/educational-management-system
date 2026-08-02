<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'EduManage'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,700;1,9..144,600&family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet" />
    @if(app()->getLocale() === 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        (function() {
            const mode = localStorage.getItem('mode') || 'light';
            if (mode === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <style>
        :root {
            --bg-page: #fbf7ee;
            --bg-alt: #f2ead7;
            --bg-card: #fffdf7;
            --bg-sidebar: #201a12;
            --text-main: #201a12;
            --text-muted: #6b6255;
            --text-sidebar: #f3ead9;
            --text-sidebar-muted: #7a6e5d;
            --border-color: #ded2b5;
            --accent-color: #b5501f;
            --status-green: #2f5c3f;
        }

        .dark {
            --bg-page: #171310;
            --bg-alt: #211b15;
            --bg-card: #1f1a14;
            --bg-sidebar: #100d0a;
            --text-main: #f3ead9;
            --text-muted: #a89a83;
            --text-sidebar: #f3ead9;
            --text-sidebar-muted: #7a6e5d;
            --border-color: #3a3126;
            --accent-color: #e78a4a;
            --status-green: #7bbf95;
        }

        [x-cloak] { display: none !important; }
        html { scroll-behavior: smooth; }
        .font-display { font-family: 'Fraunces', {{ app()->getLocale() === 'ar' ? "'Noto Sans Arabic', " : '' }}serif; }
        .font-mono-label { font-family: 'JetBrains Mono', monospace; letter-spacing: 0.06em; }

        body {
            font-family: {{ app()->getLocale() === 'ar' ? "'Noto Sans Arabic', 'Inter', sans-serif" : "'Inter', sans-serif" }};
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden;
            background-color: var(--bg-page);
            color: var(--text-main);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .dashboard-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
            background-color: var(--bg-page);
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
            background-color: var(--bg-page);
        }

        .content-padding {
            padding: 1.5rem;
        }

        @media (min-width: 640px) {
            .content-padding { padding: 2.5rem; }
        }

        @media (min-width: 1024px) {
            .content-padding { padding: 3rem; }
        }

        .card-custom {
            background-color: var(--bg-card);
            border: 1.5px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1.5rem;
            color: var(--text-main);
        }

        .sidebar-scrollbar::-webkit-scrollbar { width: 4px; }
        .sidebar-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.05); border-radius: 20px; }
    </style>
</head>
<body class="antialiased">
    <div x-data="{ sidebarOpen: window.innerWidth > 1024 }" class="dashboard-container">
        @include('partials.sidebar')

        <div class="main-content">
            @include('partials.navbar')

            <main style="flex: 1; padding-bottom: 8rem; width: 100%;">
                <div style="max-width: 80rem; margin: 0 auto; width: 100%;" class="content-padding">
                    @if (isset($header))
                        <div style="margin-bottom: 2.5rem;">{{ $header }}</div>
                    @elseif(View::hasSection('header'))
                        <div style="margin-bottom: 2.5rem;">@yield('header')</div>
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
