<x-action-section>
    <x-slot name="title">
        Kustuta konto
    </x-slot>

    <x-slot name="description">
        Konto kustutamine on püsiv ja seda ei saa tagasi võtta.
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-zinc-400">
            Kui kustutad konto, eemaldatakse kõik sinu andmed jäädavalt. Palun lae enne alla kõik oluline info, mida soovid säilitada.
        </div>

        <div class="mt-5">
            <button
                type="button"
                class="px-3 py-2 hover:bg-zinc-700 text-white border border-red-500 rounded"
                wire:click="confirmUserDeletion"
                wire:loading.attr="disabled"
            >
                Kustuta konto
            </button>
        </div>

        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">
                Konto kustutamine
            </x-slot>

            <x-slot name="content">
                <div class="text-sm text-zinc-300">
                    Oled kindel? Konto kustutamine eemaldab sinu konto ja andmed jäädavalt. Kinnitamiseks sisesta oma parool.
                </div>

                <div class="mt-4">
                    <x-input
                        type="password"
                        class="mt-1 block w-3/4 bg-zinc-900 border border-zinc-700 text-zinc-200 placeholder-zinc-500 rounded shadow focus:outline-none focus:ring-0 focus:border-zinc-500"
                        placeholder="Parool"
                        wire:model="password"
                        wire:keydown.enter="deleteUser"
                    />

                    <x-input-error for="password" class="mt-2 text-red-400" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <button
                    type="button"
                    class="px-3 py-2 hover:bg-zinc-700 text-white border border-zinc-700 rounded"
                    wire:click="$toggle('confirmingUserDeletion')"
                    wire:loading.attr="disabled"
                >
                    Katkesta
                </button>

                <button
                    type="button"
                    class="ms-3 px-3 py-2 bg-red-600 hover:bg-red-700 text-white border border-red-500 rounded shadow"
                    wire:click="deleteUser"
                    wire:loading.attr="disabled"
                >
                    Kustuta jäädavalt
                </button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
