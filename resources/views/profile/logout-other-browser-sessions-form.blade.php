<x-action-section>
    <x-slot name="title">
        Logi teistest seadmetest välja
    </x-slot>

    <x-slot name="description">
        Halda ja logi välja teistest brauseritest/seadmetest.
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-zinc-400">
            Kui soovid, saad logida välja kõikidest teistest seadmetest. Selleks pead sisestama oma parooli.
        </div>

        @if (count($this->sessions) > 0)
            <div class="mt-5 space-y-4">
                @foreach ($this->sessions as $session)
                    <div class="flex items-center justify-between bg-zinc-900 border border-zinc-700 rounded shadow p-4">
                        <div class="flex items-center gap-3">
                            <div class="text-zinc-300">
                                <div class="text-sm font-semibold">
                                    {{ $session->agent->platform() ? $session->agent->platform() : 'Tundmatu' }}
                                    —
                                    {{ $session->agent->browser() ? $session->agent->browser() : 'Tundmatu' }}
                                </div>
                                <div class="text-xs text-zinc-400">
                                    {{ $session->ip_address }},
                                    Viimati aktiivne: {{ $session->last_active }}
                                </div>
                            </div>
                        </div>

                        <div class="text-sm">
                            @if ($session->is_current_device)
                                <span class="text-green-400 font-semibold">See seade</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-5">
            <button
                type="button"
                class="px-3 py-2 bg-zinc-600 hover:bg-zinc-700 text-white border border-zinc-700 rounded shadow"
                wire:click="confirmLogout"
            >
                Logi teistest seadmetest välja
            </button>
        </div>

        <x-dialog-modal wire:model.live="confirmingLogout">
            <x-slot name="title">
                Kinnita väljalogimine
            </x-slot>

            <x-slot name="content">
                <div class="text-sm text-zinc-300">
                    Palun sisesta oma parool, et logida teistest seadmetest välja.
                </div>

                <div class="mt-4">
                    <x-input
                        type="password"
                        class="mt-1 block w-3/4 bg-zinc-900 border border-zinc-700 text-zinc-200 placeholder-zinc-500 rounded shadow focus:outline-none focus:ring-0 focus:border-zinc-500"
                        placeholder="Parool"
                        wire:model="password"
                        wire:keydown.enter="logoutOtherBrowserSessions"
                    />
                    <x-input-error for="password" class="mt-2 text-red-400" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <button
                    type="button"
                    class="px-3 py-2 hover:bg-zinc-700 text-white border border-zinc-700 rounded"
                    wire:click="$toggle('confirmingLogout')"
                    wire:loading.attr="disabled"
                >
                    Katkesta
                </button>

                <button
                    type="button"
                    class="ms-3 px-3 py-2 bg-zinc-600 hover:bg-zinc-700 text-white border border-zinc-700 rounded shadow"
                    wire:click="logoutOtherBrowserSessions"
                    wire:loading.attr="disabled"
                >
                    Kinnita
                </button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
