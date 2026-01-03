<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        Profiili andmed
    </x-slot>

    <x-slot name="description">
        Uuenda oma konto profiili infot ja e-posti aadressi.
    </x-slot>

    <x-slot name="form">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div class="col-span-6 sm:col-span-4">
                <x-label for="photo" value="Profiilipilt" class="text-zinc-300" />

                <div class="mt-2 flex items-center gap-4">
                    <span class="inline-block h-16 w-16 rounded bg-zinc-900 border border-zinc-700 overflow-hidden">
                        @if ($this->user->profile_photo_url)
                            <img src="{{ $this->user->profile_photo_url }}" alt="Profiilipilt" class="h-16 w-16 object-cover">
                        @endif
                    </span>

                    <input type="file" class="hidden" wire:model="photo" id="photo" />

                    <button
                        type="button"
                        class="px-3 py-2 bg-zinc-600 hover:bg-zinc-700 text-white border border-zinc-700 rounded shadow"
                        onclick="document.getElementById('photo').click()"
                    >
                        Vali uus pilt
                    </button>

                    @if ($this->user->profile_photo_path)
                        <button
                            type="button"
                            class="px-3 py-2 hover:bg-zinc-700 text-white border border-zinc-700 rounded"
                            wire:click="deleteProfilePhoto"
                        >
                            Eemalda pilt
                        </button>
                    @endif
                </div>

                <x-input-error for="photo" class="mt-2 text-red-400" />
            </div>
        @endif

        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="Kasutajanimi" class="text-zinc-300" />
            <x-input
                id="name"
                type="text"
                class="mt-1 block w-full bg-zinc-900 border border-zinc-700 text-zinc-200 placeholder-zinc-500 rounded shadow focus:outline-none focus:ring-0 focus:border-zinc-500"
                wire:model.defer="state.name"
                autocomplete="name"
            />
            <x-input-error for="name" class="mt-2 text-red-400" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="E-post" class="text-zinc-300" />
            <x-input
                id="email"
                type="email"
                class="mt-1 block w-full bg-zinc-900 border border-zinc-700 text-zinc-200 placeholder-zinc-500 rounded shadow focus:outline-none focus:ring-0 focus:border-zinc-500"
                wire:model.defer="state.email"
                autocomplete="username"
            />
            <x-input-error for="email" class="mt-2 text-red-400" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="mt-2 text-sm text-zinc-400">
                    Sinu e-post ei ole kinnitatud.

                    <button type="button" class="underline text-zinc-200 hover:text-white" wire:click.prevent="sendEmailVerification">
                        Saada kinnituse e-kiri uuesti
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 text-sm text-green-400">
                        Kinnituse link on saadetud sinu e-posti aadressile.
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3 text-zinc-300" on="saved">
            Salvestatud.
        </x-action-message>

        <x-button class="bg-zinc-600 hover:bg-zinc-700 text-white border border-zinc-700 focus:ring-0">
            Salvesta
        </x-button>
    </x-slot>
</x-form-section>
