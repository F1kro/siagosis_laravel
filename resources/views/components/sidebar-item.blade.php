@props(['route', 'icon', 'text'])

<a href="{{ route($route) }}" class="{{ request()->routeIs($route) || request()->routeIs($route.'.*') ? 'bg-primary-700' : 'hover:bg-primary-700' }} text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <i class="{{ $icon }} mr-3 flex-shrink-0 h-6 w-6"></i>
    {{ $text }}
</a>