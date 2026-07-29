@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-slate-300 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-300 focus:border-teal-500 dark:focus:border-teal-600 focus:ring-teal-500/20 dark:focus:ring-teal-600/20 rounded-xl shadow-sm transition-all']) !!}>
