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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    @if(app()->getLocale() === 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-main: #f8fafc;
            --bg-card: #ffffff;
            --bg-sidebar: #1e293b;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #f1f5f9;
            --accent-color: #4f46e5;
            --sidebar-text: #94a3b8;
        }

        .dark {
            --bg-main: #020617;
            --bg-card: #0f172a;
            --bg-sidebar: #020617;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border-color: #1e293b;
            --accent-color: #6366f1;
            --sidebar-text: #64748b;
        }

        [x-cloak] { display: none !important; }

        body {
            font-family: {{ app()->getLocale() === 'ar' ? "'Noto Sans Arabic', 'Inter', sans-serif" : "'Inter', sans-serif" }};
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden;
            background-color: var(--bg-main);
            color: var(--text-main);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

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
            border: 1px solid var(--border-color);
            border-radius: 1.5rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
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
