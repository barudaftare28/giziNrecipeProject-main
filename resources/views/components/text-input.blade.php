@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'border border-neutral-200 bg-white text-neutral-900
         focus:border-emerald-500 focus:ring-emerald-500
         rounded-sm shadow-sm',
]) !!}>
