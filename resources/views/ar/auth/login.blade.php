<x-guest-layout>
    <div class="space-y-8">
        <div>
            <h2 class="text-center text-3xl font-extrabold text-stone-900 dark:text-white">
                {{ __('messages.login_title') }}
            </h2>
        </div>

        <!-- Session Status -->
        @if(session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 dark:text-red-400">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <form class="space-y-6" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="code" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1" style="color: var(--text-main); font-weight: 700;">{{ __('messages.code') }}</label>
                    <input
                        id="code"
                        name="code"
                        type="text"
                        value="{{ old('code') }}"
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-stone-300 dark:border-stone-800 placeholder-stone-500 dark:placeholder-stone-600 text-stone-900 dark:text-white bg-white dark:bg-stone-950 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all sm:text-sm"
                        style="background-color: var(--bg-card); color: var(--text-main); border: 1px solid var(--border-color); border-radius: 0.75rem;"
                        placeholder="{{ __('messages.code_placeholder') }}"
                    >
                </div>

                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1" style="color: var(--text-main); font-weight: 700;">{{ __('messages.password') }}</label>
                    <div style="position: relative;">
                        <input
                            id="password"
                            name="password"
                            :type="showPassword ? 'text' : 'password'"
                            required
                            autocomplete="current-password"
                            class="appearance-none relative block w-full px-4 py-3 border border-stone-300 dark:border-stone-800 placeholder-stone-500 dark:placeholder-stone-600 text-stone-900 dark:text-white bg-white dark:bg-stone-950 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all sm:text-sm"
                            style="background-color: var(--bg-card); color: var(--text-main); border: 1px solid var(--border-color); border-radius: 0.75rem; width: 100%; {{ app()->getLocale() === 'ar' ? 'padding-left: 3rem;' : 'padding-right: 3rem;' }}"
                            placeholder="{{ __('messages.password_placeholder') }}"
                        >
                        <button type="button" @click="showPassword = !showPassword" style="position: absolute; top: 0; bottom: 0; {{ app()->getLocale() === 'ar' ? 'left: 1rem;' : 'right: 1rem;' }} display: flex; align-items: center; background: transparent; border: none; cursor: pointer; color: var(--text-muted); z-index: 20;">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPassword" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex items-center" style="display: flex; align-items: center; gap: 0.5rem;">
                <input
                    id="remember_me"
                    name="remember"
                    type="checkbox"
                    class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-stone-300 dark:border-stone-800 rounded dark:bg-stone-950"
                    style="width: 1rem; height: 1rem;"
                >
                <label for="remember_me" class="ml-2 block text-sm" style="color: var(--text-muted); font-size: 0.875rem;">
                    {{ __('messages.remember_me') }}
                </label>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all shadow-lg shadow-orange-600/20">
                    {{ __('messages.login_button') }}
                </button>
            </div>
        </form>

        <div class="text-center text-sm">
            <p class="text-stone-600 dark:text-stone-500 mt-2">
                {{ __('messages.parent_question') }}
                <a href="{{ route('parent.login') }}" class="font-bold text-orange-600 dark:text-orange-400 hover:text-orange-500 transition-colors">
                    {{ __('messages.login_here') }}
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
