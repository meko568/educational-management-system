<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just enter your student code and we will send you a password reset link.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Student Code -->
        <div>
            <x-input-label for="code" :value="__('Student Code')" />
            <x-text-input 
                id="code" 
                class="block mt-1 w-full" 
                type="text" 
                name="code" 
                :value="old('code')" 
                required 
                autofocus 
                placeholder="Enter your student code"
            />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Send Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
