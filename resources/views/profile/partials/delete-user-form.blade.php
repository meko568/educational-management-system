<section class="space-y-6">
    <header>
        <h2 class="text-xl font-black text-red-700 dark:text-red-500 uppercase tracking-tight">
            {{ __('messages.account_termination') }}
        </h2>
        <p class="mt-2 text-sm text-red-600/60 dark:text-red-400/60 font-medium">
            {{ __('messages.account_termination_description') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 bg-red-600 text-white rounded-2xl font-black text-sm shadow-xl shadow-red-900/10 hover:bg-red-700 transition-all uppercase tracking-widest"
    >{{ __('messages.request_deletion') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10 bg-white dark:bg-stone-900">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-black text-stone-900 dark:text-white leading-tight">
                {{ __('messages.are_you_absolutely_sure') }}
            </h2>

            <p class="mt-4 text-sm text-stone-500 dark:text-stone-400 leading-relaxed">
                {{ __('messages.delete_confirmation_text') }}
            </p>

            <div class="mt-8">
                <x-input-label for="password" value="{{ __('messages.confirm_password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full border-stone-200 dark:border-stone-800 bg-white dark:bg-stone-950 text-stone-900 dark:text-white focus:ring-red-500/20 focus:border-red-500 rounded-2xl font-bold p-4"
                    placeholder="{{ __('messages.verification_password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="flex-1 px-6 py-4 bg-stone-100 dark:bg-stone-800 text-stone-600 dark:text-stone-400 rounded-2xl font-black text-sm hover:bg-stone-200 dark:hover:bg-stone-700 transition-all uppercase tracking-widest">
                    {{ __('messages.abort') }}
                </button>

                <button type="submit" class="flex-1 px-6 py-4 bg-red-600 text-white rounded-2xl font-black text-sm shadow-xl shadow-red-900/20 hover:bg-red-700 transition-all uppercase tracking-widest">
                    {{ __('messages.confirm_purge') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
