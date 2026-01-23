<section style="direction: rtl;">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

<div>
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name" type="text" class="mt-1 block w-full" :value="$user->name" disabled />
</div>

<div class="mt-4">
    <x-input-label for="academic_year" :value="__('Academic Year')" />
    <x-text-input id="academic_year" type="text" class="mt-1 block w-full" :value="$user->academicYear" disabled />
</div>

<div class="mt-4">
    <x-input-label for="code" :value="__('Code')" />
    <x-text-input id="code" type="text" class="mt-1 block w-full" :value="$user->code" disabled />
</div>

@if($user->phone)
<div class="mt-4">
    <x-input-label :value="__('Phone Number')" />
    <p class="mt-1">{{ $user->phone }}</p>
</div>
@endif

@if($user->parent_phone)
<div class="mt-4">
    <x-input-label :value="__('Parent\'s Phone Number')" />
    <p class="mt-1">{{ $user->parent_phone }}</p>
</div>
@endif

        </div>
    </form>
</section>
