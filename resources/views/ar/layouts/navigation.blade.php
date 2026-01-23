<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    @php
        $parentUser = Auth::guard('parent')->user();
        $appUser = Auth::user();
        $navUserName = $parentUser ? ('Parent ' . $parentUser->code) : ($appUser->name ?? '');
        $dashboardRoute = $parentUser ? route('parent.dashboard') : route('dashboard');
        $logoutRoute = $parentUser ? route('parent.logout') : route('logout');
        $showProfile = !$parentUser;
    @endphp
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ $dashboardRoute }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="$dashboardRoute" :active="request()->routeIs('dashboard') || request()->routeIs('parent.*')">
                        {{ __('messages.dashboard') }}
                    </x-nav-link>
                    @auth
                        @if(auth()->user()->is_admin)
                            <x-nav-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.*')">
                                {{ __('messages.manage_students') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ $navUserName }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if($showProfile)
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('messages.profile') }}
                            </x-dropdown-link>
                        @endif

                        <div class="px-4 py-2 text-xs text-gray-500 dark:text-gray-300">{{ __('messages.language') }}</div>
                        <button type="button" onclick="window.location.href='{{ route('lang.switch', ['locale' => 'en']) }}'" class="w-full text-left block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                            {{ __('messages.english') }}
                        </button>
                        <button type="button" onclick="window.location.href='{{ route('lang.switch', ['locale' => 'ar']) }}'" class="w-full text-left block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                            {{ __('messages.arabic') }}
                        </button>

                        <div class="px-4 py-2 text-xs text-gray-500 dark:text-gray-300">{{ __('messages.theme') }}</div>
                        <button type="button" onclick="window.setTheme('light')" class="w-full text-left block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                            {{ __('messages.theme_light') }}
                        </button>
                        <button type="button" onclick="window.setTheme('dark')" class="w-full text-left block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                            {{ __('messages.theme_dark') }}
                        </button>
                        <button type="button" onclick="window.setTheme('system')" class="w-full text-left block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                            {{ __('messages.theme_system') }}
                        </button>

                        <!-- Authentication -->
                        <form method="POST" action="{{ $logoutRoute }}">
                            @csrf

                            <x-dropdown-link :href="$logoutRoute"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('messages.log_out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="$dashboardRoute" :active="request()->routeIs('dashboard') || request()->routeIs('parent.*')">
                {{ __('messages.dashboard') }}
            </x-responsive-nav-link>
            @auth
                @if(auth()->user()->is_admin)
                    <x-responsive-nav-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.*')">
                        {{ __('messages.manage_students') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ $navUserName }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @if($showProfile)
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('messages.profile') }}
                    </x-responsive-nav-link>
                @endif

                <div class="px-4 py-2 text-xs text-gray-500 dark:text-gray-300">{{ __('messages.language') }}</div>
                <button type="button" onclick="window.location.href='{{ route('lang.switch', ['locale' => 'en']) }}'" class="w-full text-left block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                    {{ __('messages.english') }}
                </button>
                <button type="button" onclick="window.location.href='{{ route('lang.switch', ['locale' => 'ar']) }}'" class="w-full text-left block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                    {{ __('messages.arabic') }}
                </button>

                <div class="px-4 py-2 text-xs text-gray-500 dark:text-gray-300">{{ __('messages.theme') }}</div>
                <button type="button" onclick="window.setTheme('light')" class="w-full text-left block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                    {{ __('messages.theme_light') }}
                </button>
                <button type="button" onclick="window.setTheme('dark')" class="w-full text-left block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                    {{ __('messages.theme_dark') }}
                </button>
                <button type="button" onclick="window.setTheme('system')" class="w-full text-left block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                    {{ __('messages.theme_system') }}
                </button>

                <!-- Authentication -->
                <form method="POST" action="{{ $logoutRoute }}">
                    @csrf

                    <x-responsive-nav-link :href="$logoutRoute"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('messages.log_out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
