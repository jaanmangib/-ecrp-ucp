<x-form-section submit="updatePassword">
    <x-slot name="title">
        <span class="text-zinc-200">Muuda parooli</span>
    </x-slot>

    <x-slot name="description">
        <span class="text-zinc-400">
            Kasuta pikka ja tugevat parooli, et konto oleks turvaline.
        </span>
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="Praegune parool" class="text-zinc-300" />
            <x-input
                id="current_password"
                type="password"
                class="mt-1 block w-full bg-zinc-900 border-zinc-700 text-zinc-200 focus:border-zinc-500"
                wire:model="state.current_password"
                autocomplete="current-password"
            />
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="Uus parool" class="text-zinc-300" />
            <x-input
                id="password"
                type="password"
                class="mt-1 block w-full bg-zinc-900 border-zinc-700 text-zinc-200 focus:border-zinc-500"
                wire:model="state.password"
                autocomplete="new-password"
            />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="Kinnita uus parool" class="text-zinc-300" />
            <x-input
                id="password_confirmation"
                type="password"
                class="mt-1 block w-full bg-zinc-900 border-zinc-700 text-zinc-200 focus:border-zinc-500"
                wire:model="state.password_confirmation"
                autocomplete="new-password"
            />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3 text-zinc-300" on="saved">
            Salvestatud.
        </x-action-message>

        <button
            type="submit"
            class="px-3 py-2 rounded bg-zinc-600 hover:bg-zinc-700 text-white"
            wire:loading.attr="disabled"
            wire:target="updatePassword"
        >
            Salvesta
        </button>
    </x-slot>
</x-form-section>
