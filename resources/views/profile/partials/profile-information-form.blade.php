<section class="space-y-8">
    <header>
        <h2 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
            {{ __('messages.update_information') }}
        </h2>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            {{ __("messages.update_info_description") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name (Read-only) -->
            <div class="space-y-2">
                <x-input-label for="name" :value="__('messages.display_name')" class="text-[10px] font-black uppercase text-slate-400 dark:text-slate-500 tracking-widest" />
                <div class="px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 rounded-xl text-sm font-bold text-slate-500 dark:text-slate-400 cursor-not-allowed">
                    {{ $user->name }}
                </div>
            </div>

            <!-- Email (Read-only/Placeholder) -->
            <div class="space-y-2">
                <x-input-label for="email" :value="__('messages.email_address')" class="text-[10px] font-black uppercase text-slate-400 dark:text-slate-500 tracking-widest" />
                <div class="px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 rounded-xl text-sm font-bold text-slate-500 dark:text-slate-400 cursor-not-allowed">
                    {{ $user->email ?? 'no-email@school.edu' }}
                </div>
            </div>

            <!-- Phone -->
            <div class="space-y-2">
                <x-input-label for="phone" :value="__('messages.personal_phone')" class="text-[10px] font-black uppercase text-slate-400 dark:text-slate-500 tracking-widest" />
                <x-text-input id="phone" name="phone" type="text" class="block w-full border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-teal-500/20 focus:border-teal-500 rounded-xl font-bold text-sm" :value="old('phone', $user->phone)" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <!-- Parent Phone -->
            <div class="space-y-2">
                <x-input-label for="parent_phone" :value="__('messages.guardian_phone')" class="text-[10px] font-black uppercase text-slate-400 dark:text-slate-500 tracking-widest" />
                <x-text-input id="parent_phone" name="parent_phone" type="text" class="block w-full border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-teal-500/20 focus:border-teal-500 rounded-xl font-bold text-sm" :value="old('parent_phone', $user->parent_phone)" />
                <x-input-error class="mt-2" :messages="$errors->get('parent_phone')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-8 py-3 bg-[#1E293B] dark:bg-teal-600 text-white rounded-2xl font-black text-sm shadow-xl shadow-slate-900/10 hover:bg-slate-800 dark:hover:bg-teal-500 transition-all">
                {{ __('messages.save_changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-bold text-teal-600 dark:text-teal-400"
                >{{ __('messages.information_saved') }}</p>
            @endif
        </div>
    </form>
</section>
