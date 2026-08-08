<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EduManage | {{ __('messages.home_title') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,700;1,9..144,600&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    @if(app()->getLocale() === 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @endif

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-main: #fbf7ee;
            --bg-alt: #f2ead7;
            --bg-sidebar: #201a12;
            --text-main: #201a12;
            --text-muted: #6b6255;
            --text-sidebar: #f3ead9;
            --text-sidebar-muted: #7a6e5d;
            --border-color: #ded2b5;
            --card-bg: #fffdf7;
            --accent-color: #b5501f;
            --accent-ink: #b5501f;
            --stamp-green: #2f5c3f;
            --grid-line: rgba(32, 26, 18, 0.06);
        }

        html {
            scroll-behavior: smooth;
        }

        .dark {
            --bg-main: #171310;
            --bg-alt: #211b15;
            --bg-sidebar: #100d0a;
            --text-main: #f3ead9;
            --text-muted: #a89a83;
            --text-sidebar: #f3ead9;
            --text-sidebar-muted: #7a6e5d;
            --border-color: #3a3126;
            --card-bg: #1f1a14;
            --accent-color: #e78a4a;
            --accent-ink: #e78a4a;
            --stamp-green: #7bbf95;
            --grid-line: rgba(255, 250, 240, 0.06);
        }

        body {
            font-family: {{ app()->getLocale() === 'ar' ? "'Noto Sans Arabic', 'Inter', sans-serif" : "'Inter', sans-serif" }};
            margin: 0;
            background-color: var(--bg-main);
            color: var(--text-main);
            background-image:
                linear-gradient(var(--grid-line) 1px, transparent 1px),
                linear-gradient(90deg, var(--grid-line) 1px, transparent 1px);
            background-size: 32px 32px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .font-display { font-family: 'Fraunces', {{ app()->getLocale() === 'ar' ? "'Noto Sans Arabic', " : '' }}serif; }
        .font-mono-label { font-family: 'JetBrains Mono', monospace; letter-spacing: 0.08em; }

        .ink-mark { position: relative; white-space: nowrap; font-style: italic; }
        .ink-mark::after {
            content: '';
            position: absolute;
            left: -4px; right: -4px; bottom: 0.08em;
            height: 0.34em;
            background: var(--accent-ink);
            opacity: 0.28;
            transform: rotate(-1deg);
            z-index: -1;
            border-radius: 2px;
        }

        .hard-shadow { box-shadow: 5px 5px 0 0 var(--text-main); }
        .dark .hard-shadow { box-shadow: 5px 5px 0 0 var(--accent-color); }
        .hard-shadow-sm { box-shadow: 3px 3px 0 0 var(--text-main); }
        .dark .hard-shadow-sm { box-shadow: 3px 3px 0 0 var(--accent-color); }

        .stamp {
            transform: rotate(-3deg);
            border: 2px dashed var(--accent-ink);
            color: var(--accent-ink);
        }

        .paper-card {
            background-color: var(--card-bg);
            border: 1.5px solid var(--border-color);
        }

        .ticket::before, .ticket::after {
            content: '';
            position: absolute;
            width: 28px; height: 28px;
            border-radius: 9999px;
            background-color: var(--bg-main);
            top: 50%;
            transform: translateY(-50%);
        }
        .ticket::before { left: -14px; }
        .ticket::after { right: -14px; }

        .leader-row { border-bottom: 1px dotted var(--border-color); }

        .container-custom { max-width: 1200px; margin-left: auto; margin-right: auto; padding-left: 1.5rem; padding-right: 1.5rem; }
        .section-padding { padding-top: 5rem; padding-bottom: 5rem; }
        @media (min-width: 1024px) { .section-padding { padding-top: 7rem; padding-bottom: 7rem; } }
    </style>
</head>
<body class="antialiased selection:bg-orange-200 selection:text-orange-900">
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
            <main>
        <!-- Hero Section -->
        <section class="relative overflow-hidden section-padding" style="border-bottom: 1px solid var(--border-color);">
            <div class="container-custom">
                <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-center">
                    <div class="lg:col-span-7 text-center lg:text-left {{ app()->getLocale() === 'ar' ? 'lg:text-right' : '' }}">
                        <div class="stamp inline-flex items-center px-4 py-1.5 rounded-full mb-8 font-mono-label text-xs font-bold uppercase">
                            {{ __('messages.hero_badge') }}
                        </div>

                        <h1 class="font-display text-5xl lg:text-6xl font-medium tracking-tight leading-[1.08] mb-8" style="color: var(--text-main);">
                            @php
                                $title = __('messages.home_title');
                                if (app()->getLocale() === 'en') {
                                    $title = str_replace('modern education.', '<span class="ink-mark">modern education.</span>', $title);
                                } else {
                                    $title = str_replace('التعليم الحديث.', '<span class="ink-mark">التعليم الحديث.</span>', $title);
                                }
                            @endphp
                            {!! $title !!}
                        </h1>

                        <p class="text-lg leading-relaxed max-w-xl mx-auto lg:mx-0 mb-10" style="color: var(--text-muted);">
                            {{ __('messages.home_subtitle') }}
                        </p>

                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-5">
                            <a href="{{ route('login') }}" class="hard-shadow px-7 py-3.5 font-mono-label font-bold text-sm uppercase rounded-md transition-transform duration-150 hover:-transtone-y-0.5 flex items-center justify-center" style="background-color: var(--text-main); color: var(--bg-main); border: 1.5px solid var(--text-main);">
                                {{ __('messages.launch_portal') }}
                                <svg class="{{ app()->getLocale() === 'ar' ? 'mr-2 rotate-180' : 'ml-2' }} w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                            <a href="#features" class="hard-shadow-sm px-7 py-3.5 font-mono-label font-bold text-sm uppercase rounded-md transition-transform duration-150 hover:-transtone-y-0.5 flex items-center justify-center" style="background-color: var(--card-bg); color: var(--text-main); border: 1.5px solid var(--text-main);">
                                {{ __('messages.view_specs') }}
                            </a>
                        </div>
                    </div>

                    <div class="hidden lg:block lg:col-span-5 relative mt-16 lg:mt-0">
                        <div class="paper-card hard-shadow rounded-lg p-7 relative" style="transform: rotate(2deg);">
                            <div class="flex items-center justify-between mb-6 font-mono-label text-xs uppercase" style="color: var(--text-muted);">
                                <span>{{ __('messages.academic_year') }} 2025/26</span>
                                <span class="px-2 py-0.5 rounded-full font-bold" style="border: 1px solid var(--stamp-green); color: var(--stamp-green);">{{ __('messages.active') }}</span>
                            </div>

                            <div class="leader-row flex items-baseline justify-between py-3">
                                <span style="color: var(--text-muted);">{{ __('messages.attendance') }}</span>
                                <span class="font-mono-label text-xl font-bold">98.4%</span>
                            </div>
                            <div class="leader-row flex items-baseline justify-between py-3">
                                <span style="color: var(--text-muted);">{{ __('messages.auto_revision') }}</span>
                                <span class="font-mono-label text-xl font-bold">1,204</span>
                            </div>
                            <div class="leader-row flex items-baseline justify-between py-3">
                                <span style="color: var(--text-muted);">{{ __('messages.parents') }}</span>
                                <span class="font-mono-label text-xl font-bold">3,110</span>
                            </div>
                            <div class="flex items-baseline justify-between py-3">
                                <span style="color: var(--text-muted);">{{ __('messages.exams') }}</span>
                                <span class="font-mono-label text-xl font-bold">87<span style="font-size: 0.9rem; color: var(--text-muted);">/100 avg</span></span>
                            </div>

                            <div class="stamp absolute -bottom-5 -right-5 rounded-full w-20 h-20 flex items-center justify-center font-display font-bold text-lg" style="background-color: var(--card-bg); transform: rotate(-12deg);">
                                A+
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="section-padding" style="background-color: var(--bg-alt); border-bottom: 1px solid var(--border-color);">
            <div class="container-custom">
                <div class="max-w-2xl mb-16 lg:mb-20">
                    <h2 class="font-mono-label text-xs font-bold uppercase mb-4" style="color: var(--accent-ink);">{{ __('messages.core_modules') }}</h2>
                    <p class="font-display text-3xl lg:text-4xl font-medium tracking-tight mb-5" style="color: var(--text-main);">{{ __('messages.unified_intelligence') }}</p>
                    <p class="text-lg leading-relaxed" style="color: var(--text-muted);">{{ __('messages.modules_desc') }}</p>
                </div>

                <div class="flex flex-col" style="border-top: 1.5px solid var(--border-color);">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-10 py-9" style="border-bottom: 1.5px solid var(--border-color);">
                        <div class="lg:col-span-2 font-display text-4xl font-medium" style="color: var(--accent-ink); opacity: 0.5;">01</div>
                        <div class="lg:col-span-4">
                            <h3 class="font-display text-xl font-medium mb-2" style="color: var(--text-main);">{{ __('messages.manual_archiving') }}</h3>
                        </div>
                        <div class="lg:col-span-6">
                            <p class="leading-relaxed" style="color: var(--text-muted);">{{ __('messages.manual_archiving_desc') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-10 py-9" style="border-bottom: 1.5px solid var(--border-color);">
                        <div class="lg:col-span-2 font-display text-4xl font-medium" style="color: var(--accent-ink); opacity: 0.5;">02</div>
                        <div class="lg:col-span-4">
                            <h3 class="font-display text-xl font-medium mb-2" style="color: var(--text-main);">{{ __('messages.auto_engine') }}</h3>
                        </div>
                        <div class="lg:col-span-6">
                            <p class="leading-relaxed" style="color: var(--text-muted);">{{ __('messages.auto_engine_desc') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-10 py-9" style="border-bottom: 1.5px solid var(--border-color);">
                        <div class="lg:col-span-2 font-display text-4xl font-medium" style="color: var(--accent-ink); opacity: 0.5;">03</div>
                        <div class="lg:col-span-4">
                            <h3 class="font-display text-xl font-medium mb-2" style="color: var(--text-main);">{{ __('messages.session_orchestration') }}</h3>
                        </div>
                        <div class="lg:col-span-6">
                            <p class="leading-relaxed" style="color: var(--text-muted);">{{ __('messages.session_orchestration_desc') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-10 py-9" style="border-bottom: 1.5px solid var(--border-color);">
                        <div class="lg:col-span-2 font-display text-4xl font-medium" style="color: var(--accent-ink); opacity: 0.5;">04</div>
                        <div class="lg:col-span-4">
                            <h3 class="font-display text-xl font-medium mb-2" style="color: var(--text-main);">{{ __('messages.family_portal') }}</h3>
                        </div>
                        <div class="lg:col-span-6">
                            <p class="leading-relaxed" style="color: var(--text-muted);">{{ __('messages.family_portal_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="section-padding">
            <div class="container-custom">
                <div class="ticket paper-card hard-shadow relative rounded-lg text-center py-16 px-10" style="border-style: dashed;">
                    <p class="font-mono-label text-xs font-bold uppercase mb-5" style="color: var(--accent-ink);">{{ __('messages.get_started_now') }} &middot; {{ __('messages.schedule_demo') }}</p>
                    <h2 class="font-display text-3xl lg:text-4xl font-medium tracking-tight mb-9" style="color: var(--text-main);">{{ __('messages.ready_to_modernize') }}</h2>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-5">
                        <a href="{{ route('login') }}" class="hard-shadow-sm px-7 py-3.5 font-mono-label font-bold text-sm uppercase rounded-md transition-transform duration-150 hover:-transtone-y-0.5" style="background-color: var(--text-main); color: var(--bg-main); border: 1.5px solid var(--text-main);">
                            {{ __('messages.get_started_now') }}
                        </a>
                        <a href="#" class="px-7 py-3.5 font-mono-label font-bold text-sm uppercase rounded-md transition-transform duration-150 hover:-transtone-y-0.5" style="color: var(--text-main); border: 1.5px solid var(--text-main);">
                            {{ __('messages.schedule_demo') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="pt-20 pb-12" style="background-color: var(--bg-alt); border-top: 1.5px solid var(--border-color);">
        <div class="container-custom">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-md flex items-center justify-center font-display font-bold" style="background-color: var(--text-main); color: var(--bg-main);">E</div>
                        <span class="font-display text-xl font-medium tracking-tight" style="color: var(--text-main);">EduManage</span>
                    </div>
                    <p class="leading-relaxed text-sm" style="color: var(--text-muted);">
                        {{ __('messages.footer_desc') }}
                    </p>
                </div>
                <div>
                    <h4 class="font-mono-label text-xs font-bold uppercase mb-6" style="color: var(--text-main);">{{ __('messages.platform') }}</h4>
                    <ul class="space-y-3 text-sm" style="list-style: none; padding: 0; margin: 0;">
                        <li><a href="#" style="color: var(--text-muted); text-decoration: none;">{{ __('messages.features') ?? 'Features' }}</a></li>
                        <li><a href="#" style="color: var(--text-muted); text-decoration: none;">{{ __('messages.security') ?? 'Security' }}</a></li>
                        <li><a href="#" style="color: var(--text-muted); text-decoration: none;">System Status</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-mono-label text-xs font-bold uppercase mb-6" style="color: var(--text-main);">{{ __('messages.legal') }}</h4>
                    <ul class="space-y-3 text-sm" style="list-style: none; padding: 0; margin: 0;">
                        <li><a href="#" style="color: var(--text-muted); text-decoration: none;">{{ __('messages.privacy_policy') }}</a></li>
                        <li><a href="#" style="color: var(--text-muted); text-decoration: none;">{{ __('messages.terms_of_service') }}</a></li>
                        <li><a href="#" style="color: var(--text-muted); text-decoration: none;">{{ __('messages.gdpr') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 text-center font-mono-label text-xs" style="border-top: 1.5px solid var(--border-color); color: var(--text-muted);">
                &copy; {{ date('Y') }} EduManage Institutional. All rights reserved.
            </div>
        </div>
    </footer>
    </div>
    </div>
</body>
</html>
