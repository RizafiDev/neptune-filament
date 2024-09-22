<!-- resources/views/vendor/filament/layout.blade.php -->

<x-filament::layout>
    <!-- Override the brand -->
    <x-slot name="brand">
        <a href="{{ url('../resource/images/neptune.png') }}" class="text-lg font-bold text-gray-800 dark:text-gray-200">
            <!-- Your custom brand name here -->
            Neptune Music
        </a>
    </x-slot>

    <!-- The rest of the layout remains the same -->
    {{ $slot }}
</x-filament::layout>