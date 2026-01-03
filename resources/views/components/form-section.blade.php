@props(['submit'])

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

        {{-- Parem: form kaart --}}
        <div class="lg:col-span-8">
            <form wire:submit="{{ $submit }}">
                <div class="bg-zinc-800 border border-zinc-700 rounded shadow">
                    <div class="p-6">
                        <div class="grid grid-cols-6 gap-4">
                            {{ $form }}
                        </div>
                    </div>

                    @isset($actions)
                        <div class="px-6 py-4 border-t border-zinc-700 bg-zinc-900/40 rounded-b flex items-center justify-end gap-3">
                            {{ $actions }}
                        </div>
                    @endisset
                </div>
            </form>
        </div>
    </div>
</section>
