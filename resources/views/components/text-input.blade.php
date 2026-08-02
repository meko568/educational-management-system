@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-stone-300 dark:border-stone-800 dark:bg-stone-950 dark:text-stone-300 focus:border-emerald-500 dark:focus:border-emerald-600 focus:ring-emerald-500/20 dark:focus:ring-emerald-600/20 rounded-xl shadow-sm transition-all']) !!}>
