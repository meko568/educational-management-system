@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-xs uppercase tracking-widest text-slate-700 dark:text-slate-400']) }}>
    {{ $value ?? $slot }}
</label>
