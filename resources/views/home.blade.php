<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EduManage | {{ __('messages.home_title') }}</title>

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
            --bg-main: #ffffff;
            --bg-alt: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #475569;
            --border-color: #f1f5f9;
            --card-bg: #ffffff;
        }

        .dark {
            --bg-main: #020617;
            --bg-alt: #0f172a;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border-color: #1e293b;
            --card-bg: #0f172a;
        }

        body {
            font-family: {{ app()->getLocale() === 'ar' ? "'Noto Sans Arabic', 'Inter', sans-serif" : "'Inter', sans-serif" }};
            margin: 0;
            padding: 0;
            background-color: var(--bg-main);
            color: var(--text-main);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .text-balance { text-wrap: balance; }

        .hero-gradient {
            background: radial-gradient(circle at 0% 0%, rgba(79, 70, 229, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 100% 100%, rgba(16, 185, 129, 0.08) 0%, transparent 50%);
        }

        .dark .hero-gradient {
            background: radial-gradient(circle at 0% 0%, rgba(79, 70, 229, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 100% 100%, rgba(16, 185, 129, 0.15) 0%, transparent 50%);
        }

        .container-custom {
            max-width: 1280px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .section-padding {
            padding-top: 5rem;
            padding-bottom: 5rem;
        }

        @media (min-width: 1024px) {
            .section-padding {
                padding-top: 8rem;
                padding-bottom: 8rem;
            }
        }
    </style>
</head>
<body class="antialiased selection:bg-indigo-100 selection:text-indigo-700">

    @include('partials.navbar')

    <main>
        <!-- Hero Section -->
        <section class="relative overflow-hidden hero-gradient section-padding" style="border-bottom: 1px solid var(--border-color);">
            <div class="container-custom">
                <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-center">
                    <div class="lg:col-span-7 text-center lg:text-left {{ app()->getLocale() === 'ar' ? 'lg:text-right' : '' }}">
                        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 mb-8" style="margin-bottom: 2rem;">
                            <span class="flex h-2 w-2 rounded-full bg-indigo-600" style="width: 8px; height: 8px; display: inline-block;"></span>
                            <span class="text-xs font-semibold uppercase tracking-wider text-indigo-700 dark:text-indigo-400" style="font-size: 0.75rem; {{ app()->getLocale() === 'ar' ? 'margin-right: 0.5rem;' : 'margin-left: 0.5rem;' }}">
                                {{ __('messages.hero_badge') }}
                            </span>
                        </div>

                        <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight leading-[1.1] text-balance" style="font-size: 3.5rem; line-height: 1.1; margin-bottom: 2rem; color: var(--text-main);">
                            @php
                                $title = __('messages.home_title');
                                if (app()->getLocale() === 'en') {
                                    $title = str_replace('modern education.', '<span class="text-indigo-600" style="color: #4f46e5;">modern education.</span>', $title);
                                } else {
                                    $title = str_replace('التعليم الحديث.', '<span class="text-indigo-600" style="color: #4f46e5;">التعليم الحديث.</span>', $title);
                                }
                            @endphp
                            {!! $title !!}
                        </h1>

                        <p class="text-xl leading-relaxed max-w-2xl mx-auto lg:mx-0 text-balance" style="font-size: 1.25rem; color: var(--text-muted); margin-bottom: 3rem; line-height: 1.625;">
                            {{ __('messages.home_subtitle') }}
                        </p>

                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4" style="display: flex; gap: 1rem;">
                            <a href="{{ route('login') }}" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all duration-200 flex items-center justify-center" style="background-color: #4f46e5; color: white; padding: 1rem 2rem; border-radius: 0.75rem; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.2);">
                                {{ __('messages.launch_portal') }}
                                <svg class="{{ app()->getLocale() === 'ar' ? 'mr-2 rotate-180' : 'ml-2' }} w-5 h-5" style="{{ app()->getLocale() === 'ar' ? 'margin-right: 0.5rem;' : 'margin-left: 0.5rem;' }} width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                            <a href="#features" class="px-8 py-4 font-bold rounded-xl transition-all duration-200 flex items-center justify-center" style="background-color: var(--card-bg); color: var(--text-main); padding: 1rem 2rem; border-radius: 0.75rem; border: 1px solid var(--border-color); text-decoration: none; display: inline-flex; align-items: center;">
                                {{ __('messages.view_specs') }}
                            </a>
                        </div>
                    </div>

                    <div class="hidden lg:block lg:col-span-5 relative" style="margin-top: 4rem;">
                        <div class="relative rounded-2xl bg-slate-900 dark:bg-black p-2 shadow-2xl overflow-hidden border border-slate-800" style="padding: 0.5rem; border-radius: 1rem;">
                            <div class="bg-slate-800 dark:bg-slate-900 rounded-xl aspect-[4/3] flex flex-col p-6" style="border-radius: 0.75rem; padding: 1.5rem; min-height: 300px;">
                                <div class="flex items-center space-x-2 mb-8" style="display: flex; gap: 0.5rem; margin-bottom: 2rem;">
                                    <div class="w-3 h-3 rounded-full bg-red-500/50" style="width: 12px; height: 12px; background-color: rgba(239, 68, 68, 0.5); border-radius: 9999px;"></div>
                                    <div class="w-3 h-3 rounded-full bg-amber-500/50" style="width: 12px; height: 12px; background-color: rgba(245, 158, 11, 0.5); border-radius: 9999px;"></div>
                                    <div class="w-3 h-3 rounded-full bg-emerald-500/50" style="width: 12px; height: 12px; background-color: rgba(16, 185, 129, 0.5); border-radius: 9999px;"></div>
                                </div>
                                <div class="space-y-4" style="display: flex; flex-direction: column; gap: 1rem;">
                                    <div class="h-4 w-3/4 bg-slate-700 rounded" style="height: 1rem; width: 75%; background-color: #334155; border-radius: 0.25rem;"></div>
                                    <div class="h-4 w-1/2 bg-slate-700 rounded" style="height: 1rem; width: 50%; background-color: #334155; border-radius: 0.25rem;"></div>
                                    <div class="grid grid-cols-2 gap-4 mt-8" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-top: 2rem;">
                                        <div class="h-32 bg-indigo-500/10 rounded-lg border border-indigo-500/20 flex items-center justify-center" style="height: 8rem; background-color: rgba(79, 70, 229, 0.1); border: 1px solid rgba(79, 70, 229, 0.2); border-radius: 0.5rem; display: flex; align-items: center; justify-center;">
                                            <svg class="w-8 h-8 text-indigo-400" style="width: 2rem; height: 2rem; color: #818cf8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                        </div>
                                        <div class="h-32 bg-emerald-500/10 rounded-lg border border-emerald-500/20 flex items-center justify-center" style="height: 8rem; background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 0.5rem; display: flex; align-items: center; justify-center;">
                                            <svg class="w-8 h-8 text-emerald-400" style="width: 2rem; height: 2rem; color: #34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="section-padding" style="background-color: var(--bg-alt);">
            <div class="container-custom">
                <div class="max-w-3xl mb-20" style="margin-bottom: 5rem; max-width: 48rem;">
                    <h2 class="text-base font-bold text-indigo-600 uppercase tracking-widest mb-4" style="color: #4f46e5; font-size: 0.875rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem;">{{ __('messages.core_modules') }}</h2>
                    <p class="text-4xl font-extrabold tracking-tight mb-6" style="font-size: 2.25rem; font-weight: 800; color: var(--text-main); margin-bottom: 1.5rem;">{{ __('messages.unified_intelligence') }}</p>
                    <p class="text-lg leading-relaxed" style="font-size: 1.125rem; color: var(--text-muted); line-height: 1.625;">{{ __('messages.modules_desc') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2.5rem;">
                    <!-- Manual Grade Archiving -->
                    <div class="p-8 rounded-2xl border transition-all hover:shadow-md" style="background-color: var(--card-bg); padding: 2rem; border-radius: 1rem; border: 1px solid var(--border-color); box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                        <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 rounded-lg flex items-center justify-center mb-6" style="width: 3rem; height: 3rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                            <svg class="w-6 h-6" style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3" style="font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.75rem;">{{ __('messages.manual_archiving') }}</h3>
                        <p class="text-slate-600 leading-relaxed" style="color: var(--text-muted); line-height: 1.625;">{{ __('messages.manual_archiving_desc') }}</p>
                    </div>

                    <!-- Digital Exam Engine -->
                    <div class="p-8 rounded-2xl border transition-all hover:shadow-md" style="background-color: var(--card-bg); padding: 2rem; border-radius: 1rem; border: 1px solid var(--border-color); box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                        <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-lg flex items-center justify-center mb-6" style="width: 3rem; height: 3rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                            <svg class="w-6 h-6" style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3" style="font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.75rem;">{{ __('messages.auto_engine') }}</h3>
                        <p class="text-slate-600 leading-relaxed" style="color: var(--text-muted); line-height: 1.625;">{{ __('messages.auto_engine_desc') }}</p>
                    </div>

                    <!-- Multi-Session Orchestration -->
                    <div class="p-8 rounded-2xl border transition-all hover:shadow-md" style="background-color: var(--card-bg); padding: 2rem; border-radius: 1rem; border: 1px solid var(--border-color); box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                        <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-lg flex items-center justify-center mb-6" style="width: 3rem; height: 3rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                            <svg class="w-6 h-6" style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3" style="font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.75rem;">{{ __('messages.session_orchestration') }}</h3>
                        <p class="text-slate-600 leading-relaxed" style="color: var(--text-muted); line-height: 1.625;">{{ __('messages.session_orchestration_desc') }}</p>
                    </div>

                    <!-- Family Transparency -->
                    <div class="p-8 rounded-2xl border transition-all hover:shadow-md" style="background-color: var(--card-bg); padding: 2rem; border-radius: 1rem; border: 1px solid var(--border-color); box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                        <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center mb-6" style="width: 3rem; height: 3rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                            <svg class="w-6 h-6" style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3" style="font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.75rem;">{{ __('messages.family_portal') }}</h3>
                        <p class="text-slate-600 leading-relaxed" style="color: var(--text-muted); line-height: 1.625;">{{ __('messages.family_portal_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="section-padding" style="background-color: var(--bg-main);">
            <div class="container-custom text-center">
                <div class="rounded-3xl p-12 lg:p-20 shadow-2xl relative overflow-hidden" style="background-color: #4f46e5; border-radius: 1.5rem; padding: 4rem; position: relative;">
                    <div class="relative z-10">
                        <h2 class="text-3xl lg:text-5xl font-extrabold text-white mb-8 tracking-tight" style="color: white; font-size: 3rem; margin-bottom: 2rem; font-weight: 800;">{{ __('messages.ready_to_modernize') }}</h2>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4" style="display: flex; justify-content: center; gap: 1rem;">
                            <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-indigo-600 font-bold rounded-xl shadow-lg transition-all hover:bg-slate-50" style="background-color: white; color: #4f46e5; padding: 1rem 2rem; border-radius: 0.75rem; text-decoration: none; font-weight: 700;">
                                {{ __('messages.get_started_now') }}
                            </a>
                            <a href="#" class="px-8 py-4 bg-indigo-500 text-white font-bold rounded-xl transition-all hover:bg-indigo-400 border border-indigo-400/30" style="background-color: #6366f1; color: white; padding: 1rem 2rem; border-radius: 0.75rem; text-decoration: none; border: 1px solid rgba(255,255,255,0.2);">
                                {{ __('messages.schedule_demo') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="pt-20 pb-12" style="background-color: var(--bg-alt); border-top: 1px solid var(--border-color); padding-top: 5rem; padding-bottom: 3rem;">
        <div class="container-custom">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 3rem; margin-bottom: 4rem;">
                <div>
                    <div class="flex items-center gap-3 mb-6" style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white" style="width: 2.5rem; height: 2.5rem; background-color: #4f46e5; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white;">
                            <svg class="w-6 h-6" style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /></svg>
                        </div>
                        <span class="text-xl font-bold tracking-tight" style="font-size: 1.25rem; font-weight: 700; color: var(--text-main);">EduManage</span>
                    </div>
                    <p class="leading-relaxed text-sm" style="color: var(--text-muted); font-size: 0.875rem; line-height: 1.625;">
                        {{ __('messages.footer_desc') }}
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-widest mb-6" style="font-size: 0.875rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1.5rem; color: var(--text-main);">{{ __('messages.platform') }}</h4>
                    <ul class="space-y-4 text-sm" style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 1rem;"><a href="#" style="color: var(--text-muted); text-decoration: none;">{{ __('messages.features') ?? 'Features' }}</a></li>
                        <li style="margin-bottom: 1rem;"><a href="#" style="color: var(--text-muted); text-decoration: none;">{{ __('messages.security') ?? 'Security' }}</a></li>
                        <li style="margin-bottom: 1rem;"><a href="#" style="color: var(--text-muted); text-decoration: none;">System Status</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-widest mb-6" style="font-size: 0.875rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1.5rem; color: var(--text-main);">{{ __('messages.legal') }}</h4>
                    <ul class="space-y-4 text-sm" style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 1rem;"><a href="#" style="color: var(--text-muted); text-decoration: none;">{{ __('messages.privacy_policy') }}</a></li>
                        <li style="margin-bottom: 1rem;"><a href="#" style="color: var(--text-muted); text-decoration: none;">{{ __('messages.terms_of_service') }}</a></li>
                        <li style="margin-bottom: 1rem;"><a href="#" style="color: var(--text-muted); text-decoration: none;">{{ __('messages.gdpr') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 text-center" style="padding-top: 2rem; border-top: 1px solid var(--border-color); text-align: center;">
                <p class="text-xs font-medium" style="font-size: 0.75rem; color: var(--text-muted);">&copy; {{ date('Y') }} EduManage Institutional. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
