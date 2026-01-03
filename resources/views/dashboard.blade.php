<x-layouts.ucp title="Avaleht">

    {{-- TERETUS --}}
    <div class="mb-3">
        <div class="p-4 bg-zinc-900 rounded shadow border border-zinc-700">
            <h2 class="text-2xl font-semibold text-white mb-1">
                Tere tulemast, {{ auth()->user()->name }} 👋
            </h2>
            <p class="text-sm text-zinc-400">
                Oled edukalt sisse logitud Eclipse RP kasutajapaneeli.
            </p>
        </div>
    </div>

    {{-- INFO / ARKENDUSE TEADE --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-3">
        <div class="p-4 bg-zinc-900 rounded shadow border border-zinc-700">
            <div class="text-xs uppercase tracking-wider text-zinc-400 mb-1">
                Staatus
            </div>
            <div class="text-lg font-semibold text-yellow-400">
                Arenduses
            </div>
            <p class="text-sm text-zinc-400 mt-1">
                Antud leht ja kasutajapaneel on hetkel aktiivses arenduses.
            </p>
        </div>
    </div>
</x-layouts.ucp>
