<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-stone-900 overflow-hidden shadow-sm sm:rounded-2xl border border-stone-100 dark:border-stone-800">
                <div class="p-8 text-stone-900 dark:text-stone-100">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">{{ __('messages.success') }}</h2>
                            <p class="text-stone-500 dark:text-stone-400">{{ __('messages.logged_in') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <a href="{{ route('admin.dashboard') }}" class="p-6 rounded-2xl border border-stone-100 dark:border-stone-800 hover:border-emerald-500 dark:hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/5 transition-all group">
                            <h3 class="font-bold text-stone-900 dark:text-white group-hover:text-emerald-600 transition-colors">{{ __('messages.admin_dashboard') }}</h3>
                            <p class="text-sm text-stone-500 dark:text-stone-400 mt-2">Manage students, teachers, courses and view detailed analytics.</p>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="p-6 rounded-2xl border border-stone-100 dark:border-stone-800 hover:border-orange-50 dark:hover:border-orange-900/30 hover:shadow-lg hover:shadow-orange-500/5 transition-all group">
                            <h3 class="font-bold text-stone-900 dark:text-white group-hover:text-orange-600 transition-colors">{{ __('messages.profile_settings') }}</h3>
                            <p class="text-sm text-stone-500 dark:text-stone-400 mt-2">{{ __('messages.update_profile_description') }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
