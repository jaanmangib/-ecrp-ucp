@props(['title' => null])

<x-layouts.ucp :title="$title" {{ $attributes }}>
    {{ $slot }}
</x-layouts.ucp>
