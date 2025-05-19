@props(['route', 'icon', 'label'])

@php
    $isActive = request()->routeIs($route);
@endphp

<li>
    <a href="{{ route($route) }}"
        class="flex items-center px-3 py-2 transition rounded-md hover:bg-gray-100 {{ $isActive ? 'font-bold text-blue-600 bg-blue-50' : 'text-gray-700' }}">
        <i class="{{ $icon }} mr-2 w-4"></i>
        {{ $label }}
    </a>
</li>
