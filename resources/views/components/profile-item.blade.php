@props(['label', 'value'])

<div>
    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
    <input type="text" readonly value="{{ $value }}"
        class="w-full px-4 py-2 text-sm border rounded-md dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
</div>
