@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-orange-400 dark:border-orange-600 text-start text-base font-medium text-orange-700 dark:text-orange-300 bg-orange-50 dark:bg-orange-900/50 focus:outline-none focus:text-orange-800 dark:focus:text-orange-200 focus:bg-orange-100 dark:focus:bg-orange-900 focus:border-orange-700 dark:focus:border-orange-300 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-stone-600 dark:text-stone-400 hover:text-stone-800 dark:hover:text-stone-200 hover:bg-stone-50 dark:hover:bg-stone-700 hover:border-stone-300 dark:hover:border-stone-600 focus:outline-none focus:text-stone-800 dark:focus:text-stone-200 focus:bg-stone-50 dark:focus:bg-stone-700 focus:border-stone-300 dark:focus:border-stone-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
