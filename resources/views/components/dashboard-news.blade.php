@props(['title', 'time', 'content'])

<li class="py-4">
    <div class="flex space-x-3">
        <div class="flex-1 space-y-1">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium">{{ $title }}</h3>
                <p class="text-sm text-gray-500">{{ $time }}</p>
            </div>
            <p class="text-sm text-gray-500">{{ $content }}</p>
        </div>
    </div>
</li>
