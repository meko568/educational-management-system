<nav class="w-full sticky top-0 z-[100] backdrop-blur-md border-b px-6 py-4" style="background-color: rgba(var(--bg-page-rgb, 251, 247, 238), 0.8); border-color: var(--border-color);">
    <script>
        (function() {
            const getRGB = (hex) => {
                const r = parseInt(hex.slice(1, 3), 16);
                const g = parseInt(hex.slice(3, 5), 16);
                const b = parseInt(hex.slice(5, 7), 16);
                return `${r}, ${g}, ${b}`;
            };
            const updateNavbarRGB = () => {
                const isDark = document.documentElement.classList.contains('dark');
                const hex = isDark ? '#171310' : '#fbf7ee';
                document.documentElement.style.setProperty('--bg-page-rgb', getRGB(hex));
            };
            updateNavbarRGB();
            const observer = new MutationObserver(updateNavbarRGB);
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
        })();
    </script>
    <div class="max-w-7xl mx-auto flex items-center justify-between">

        <!-- Left Side: Brand & Dashboard Title -->
        <div class="flex items-center gap-6">
            <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center text-white shadow-sm" style="background: linear-gradient(135deg, var(--accent-color), #b5501f);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                    </svg>
                </div>
                <span class="font-display hidden sm:block text-xl font-bold tracking-tight" style="color: var(--text-main);">{{ __('messages.app_name') }}</span>
            </a>

            @auth
                <div class="hidden lg:block w-px h-6" style="background-color: var(--border-color);"></div>
                <div class="nav-dashboard-title">
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('student.dashboard') }}" class="no-underline">
                        <h2 class="text-xs font-mono-label font-black uppercase tracking-widest" style="color: var(--accent-color);">
                            @if(Auth::user()->role === 'admin')
                                {{ __('messages.admin_dashboard') }}
                            @elseif(Auth::user()->role === 'student')
                                {{ __('messages.student_dashboard_title') }}
                            @else
                                {{ __('messages.dashboard') }}
                            @endif
                        </h2>
                    </a>
                </div>
            @endauth
        </div>

        <!-- Right Side: Actions -->
        <div class="flex items-center gap-4">

            <!-- Mode Toggle -->
            <div x-data="{
                mode: localStorage.getItem('mode') || 'light',
                toggle() {
                    this.mode = this.mode === 'light' ? 'dark' : 'light';
                    localStorage.setItem('mode', this.mode);
                    if (this.mode === 'dark') document.documentElement.classList.add('dark');
                    else document.documentElement.classList.remove('dark');
                }
            }" class="flex p-1 rounded-lg border bg-bg-alt" style="border-color: var(--border-color);">
                <button @click="toggle()" class="p-1.5 rounded-md transition-all duration-300 hover:bg-bg-card" style="color: var(--text-muted);">
                    <svg x-show="mode === 'dark'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m12.728 12.728L5.99 5.99" /></svg>
                    <svg x-show="mode === 'light'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                </button>
            </div>

            <!-- Language Switcher -->
            <div class="flex p-1 rounded-lg border bg-bg-alt" style="border-color: var(--border-color);">
                <a href="{{ route('lang.switch', 'en') }}"
                   class="px-3 py-1 rounded-md text-[10px] font-mono-label font-bold uppercase transition-all duration-200"
                   style="{{ app()->getLocale() === 'en' ? 'background-color: var(--bg-card); color: var(--accent-color);' : 'color: var(--text-muted);' }}">EN</a>
                <a href="{{ route('lang.switch', 'ar') }}"
                   class="px-3 py-1 rounded-md text-[10px] font-mono-label font-bold uppercase transition-all duration-200"
                   style="{{ app()->getLocale() === 'ar' ? 'background-color: var(--bg-card); color: var(--accent-color);' : 'color: var(--text-muted);' }}">AR</a>
            </div>

            @auth
                <div class="flex items-center gap-4">
                    <div class="hidden md:block text-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}">
                        <p class="text-xs font-bold uppercase leading-none" style="color: var(--text-main);">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] font-mono-label font-bold uppercase tracking-widest mt-1" style="color: var(--text-muted);">{{ Auth::user()->role }}</p>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="w-10 h-10 rounded-full flex items-center justify-center border hover:bg-bg-alt transition-all no-underline shadow-sm" style="background-color: var(--bg-card); border-color: var(--border-color); color: var(--text-muted);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 border rounded-lg text-[10px] font-mono-label font-bold uppercase tracking-widest hover:bg-bg-alt transition-all cursor-pointer" style="background-color: var(--bg-card); border-color: var(--border-color); color: var(--text-main);">
                            {{ __('messages.log_out') }}
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="px-6 py-2.5 text-white rounded-lg font-bold text-sm no-underline shadow-lg transition-transform hover:scale-105" style="background-color: var(--accent-color);">
                    {{ __('messages.login') }}
                </a>
            @endauth
        </div>
    </div>
</nav>
