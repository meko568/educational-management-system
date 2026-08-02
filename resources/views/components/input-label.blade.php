@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-xs uppercase tracking-widest text-stone-700 dark:text-stone-400']) }}>
    {{ $value ?? $slot }}
</label>
