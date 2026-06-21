@props([
    'title',
    'value' => 0,
    'icon' => null,
    'color' => 'blue',
])

@php
    $colors = [
        'blue' => 'bg-blue-100 text-blue-600',
        'green' => 'bg-green-100 text-green-600',
        'red' => 'bg-red-100 text-red-600',
        'yellow' => 'bg-yellow-100 text-yellow-600',
        'purple' => 'bg-purple-100 text-purple-600',
        'gray' => 'bg-gray-100 text-gray-600',
    ];
@endphp

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">

    <div class="flex items-center justify-between">

        <div>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $title }}
            </p>

            <h2 class="mt-2 text-3xl font-bold text-gray-800 dark:text-white">
                {{ $value }}
            </h2>

        </div>

        @if($icon)

            <div class="w-14 h-14 rounded-full flex items-center justify-center {{ $colors[$color] ?? $colors['blue'] }}">

                <i class="{{ $icon }} text-2xl"></i>

            </div>

        @endif

    </div>

</div>
