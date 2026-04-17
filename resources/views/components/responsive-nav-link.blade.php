@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full border-l-4 border-cyan-300 bg-white/10 py-2 ps-3 pe-4 text-start text-base font-medium text-white focus:border-cyan-200 focus:bg-white/10 focus:text-white focus:outline-none transition duration-150 ease-in-out'
            : 'block w-full border-l-4 border-transparent py-2 ps-3 pe-4 text-start text-base font-medium text-slate-200 hover:border-white/20 hover:bg-white/5 hover:text-white focus:border-white/20 focus:bg-white/5 focus:text-white focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
