{{-- HerdZone brand mark: minimalist cattle/ranch emblem (ring + horns + head). --}}
{{-- Usage: @include('partials.brand-mark', ['size' => 45, 'class' => 'me-3']) --}}
@php
    $size = $size ?? 40;
    $markClass = $class ?? '';
@endphp
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="{{ $size }}" height="{{ $size }}" class="{{ $markClass }}" style="flex-shrink:0;" aria-hidden="true" focusable="false">
    <circle cx="50" cy="50" r="46" fill="none" stroke="#FBBF24" stroke-width="5"/>
    <path d="M40 46 C 27 42 18 28 21 14" fill="none" stroke="#FBBF24" stroke-width="6" stroke-linecap="round"/>
    <path d="M60 46 C 73 42 82 28 79 14" fill="none" stroke="#FBBF24" stroke-width="6" stroke-linecap="round"/>
    <ellipse cx="33" cy="50" rx="7" ry="4.5" fill="#FBBF24" transform="rotate(-30 33 50)"/>
    <ellipse cx="67" cy="50" rx="7" ry="4.5" fill="#FBBF24" transform="rotate(30 67 50)"/>
    <ellipse cx="50" cy="60" rx="17" ry="14" fill="#FBBF24"/>
</svg>
