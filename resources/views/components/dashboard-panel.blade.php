@props(['title'])

<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-5 border-b border-gray-200">
        <h3 class="text-lg font-medium leading-6 text-gray-900">
            {{ $title }}
        </h3>
    </div>
    <div class="p-6">
        <ul class="divide-y divide-gray-200">
            {{ $slot }}
        </ul>
    </div>
</div>
