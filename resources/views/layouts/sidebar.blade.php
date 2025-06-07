{{-- Desktop Sidebar --}}
<aside class="z-20 flex-shrink-0 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block">
    @include('layouts.partials.sidebar-menu')
</aside>

{{-- Mobile Sidebar Overlay --}}
<div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" @click="isSideMenuOpen = false"
    class="fixed inset-0 z-10 bg-black bg-opacity-50 md:hidden"></div>

{{-- Mobile Sidebar --}}
<aside class="fixed inset-y-0 left-0 z-30 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
    x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="transform -translate-x-full" x-transition:enter-end="transform translate-x-0"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="transform translate-x-0"
    x-transition:leave-end="transform -translate-x-full" @keydown.escape.window="isSideMenuOpen = false">
    @include('layouts.partials.sidebar-menu')
</aside>