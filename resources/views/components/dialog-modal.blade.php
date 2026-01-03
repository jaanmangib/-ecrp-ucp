@props([
    'id' => null,
    'maxWidth' => '2xl'
])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="bg-zinc-800 border border-zinc-700 rounded shadow text-zinc-200">
        <div class="px-6 py-4 border-b border-zinc-700">
            <div class="text-lg font-semibold">
                {{ $title }}
            </div>

            @isset($description)
                <div class="mt-1 text-sm text-zinc-400">
                    {{ $description }}
                </div>
            @endisset
        </div>

        <div class="px-6 py-4">
            {{ $content }}
        </div>

        <div class="px-6 py-4 border-t border-zinc-700 flex justify-end gap-2">
            {{ $footer }}
        </div>
    </div>
</x-modal>
