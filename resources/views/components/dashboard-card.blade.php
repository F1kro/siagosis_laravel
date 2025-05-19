@props(['icon', 'iconBg', 'label', 'value'])

<div class="overflow-hidden bg-white rounded-lg shadow">
    <div class="p-5">
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 rounded-md {{ $iconBg }}">
                <i class="text-xl {{ $icon }}"></i>
            </div>
            <div class="flex-1 w-0 ml-5">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        {{ $label }}
                    </dt>
                    <dd>
                        <div class="text-lg font-medium text-gray-900">
                            {{ $value }}
                        </div>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>
