@props([
    'title' => 'Kinnita parool',
    'content' => 'Turvalisuse huvides sisesta oma parool, et jätkata.',
    'button' => 'Kinnita',
])

<div
    x-data="{
        confirmingPassword: false,
        password: '',
        error: '',
        async confirmAndSubmit() {
            this.error = '';

            try {
                // Jetstream/Livewire helper
                await this.$wire.startConfirmingPassword();

                // Jetstream annab URL-i confirmimiseks
                await axios.post(this.$wire.getConfirmPasswordUrl(), {
                    password: this.password
                });

                this.confirmingPassword = false;
                this.password = '';
                this.error = '';
                this.$dispatch('confirmed');
            } catch (e) {
                this.error = 'Vale parool.';
            }
        }
    }"
    x-on:confirming-password.window="
        confirmingPassword = true;
        password = '';
        error = '';
        $nextTick(() => $refs.password?.focus());
    "
    x-on:confirmed.window="
        confirmingPassword = false;
        password = '';
        error = '';
    "
>
    {{-- ✅ TRIGGER (slot) --}}
    {{ $slot }}

    <x-dialog-modal id="confirming-password" maxWidth="sm" x-show="confirmingPassword">
        <x-slot name="title">
            {{ $title }}
        </x-slot>

        <x-slot name="content">
            <div class="text-sm text-zinc-300 mb-3">
                {{ $content }}
            </div>

            <input
                x-ref="password"
                type="password"
                x-model="password"
                @keydown.enter.prevent="confirmAndSubmit()"
                class="w-full rounded bg-zinc-900 border border-zinc-700 text-zinc-200 px-3 py-2 focus:outline-none focus:border-zinc-500"
                placeholder="Parool"
            />

            <template x-if="error">
                <div class="mt-2 text-sm text-red-400" x-text="error"></div>
            </template>
        </x-slot>

        <x-slot name="footer">
            <button
                type="button"
                class="px-3 py-2 rounded border border-zinc-700 text-zinc-200 hover:bg-zinc-700"
                @click="confirmingPassword=false; password=''; error='';"
            >
                Tühista
            </button>

            <button
                type="button"
                class="px-3 py-2 rounded bg-zinc-600 hover:bg-zinc-700 text-white"
                @click="confirmAndSubmit()"
            >
                {{ $button }}
            </button>
        </x-slot>
    </x-dialog-modal>
</div>
