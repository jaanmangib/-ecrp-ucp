@props(['title', 'description'])

<section class="w-full">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-6">
        {{-- Vasak: pealkiri + kirjeldus --}}
        <div class="lg:col-span-4">
            <h2 class="text-lg font-semibold text-white">
                {{ $title }}
            </h2>

            @isset($description)
                <p class="mt-1 text-sm text-zinc-400">
                    {{ $description }}
                </p>
            @endisset
        </div>

        {{-- Parem: sisu kaart --}}
        <div class="lg:col-span-8">
            <div class="bg-zinc-800 border border-zinc-700 rounded shadow p-6">
                {{ $content }}
            </div>
        </div>
    </div>
</section>
