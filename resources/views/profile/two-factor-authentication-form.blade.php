<x-action-section>
    <x-slot name="title">
        Kaheastmeline autentimine (2FA)
    </x-slot>

    <x-slot name="description">
        Lisa oma kontole lisakaitse, kasutades autentimisrakendust.
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-medium text-zinc-200">
            @if ($this->enabled)
                2FA on sisse lülitatud.
            @else
                2FA ei ole sisse lülitatud.
            @endif
        </h3>

        <div class="mt-3 max-w-xl text-sm text-zinc-400">
            <p>
                Kui 2FA on sees, pead sisselogimisel sisestama ka turvakoodi autentimisrakendusest.
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4">
                    <div class="text-sm text-zinc-300">
                        Skänni see QR-kood oma autentimisrakendusega:
                    </div>

                    <div class="mt-4 p-4 bg-zinc-900 border border-zinc-700 rounded shadow inline-block">
                        {!! $this->user->twoFactorQrCodeSvg() !!}
                    </div>
                </div>
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4">
                    <div class="text-sm text-zinc-300">
                        Salvesta taastamiskoodid turvalisse kohta. Neid saad kasutada, kui kaotad ligipääsu autentimisrakendusele.
                    </div>

                    <div class="mt-4 bg-zinc-900 border border-zinc-700 rounded shadow p-4">
                        <div class="grid gap-1 font-mono text-sm text-zinc-200">
                            @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                                <div>{{ $code }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <div class="mt-5 flex flex-wrap gap-2">
            @if (! $this->enabled)
                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <button class="px-3 py-2 bg-zinc-600 hover:bg-zinc-700 text-white border border-zinc-700 rounded shadow">
                        Lülita 2FA sisse
                    </button>
                </x-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <button class="px-3 py-2 bg-zinc-600 hover:bg-zinc-700 text-white border border-zinc-700 rounded shadow">
                            Genereeri uued taastamiskoodid
                        </button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showRecoveryCodes">
                        <button class="px-3 py-2 bg-zinc-600 hover:bg-zinc-700 text-white border border-zinc-700 rounded shadow">
                            Näita taastamiskoode
                        </button>
                    </x-confirms-password>
                @endif

                @if ($showingQrCode)
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <button class="px-3 py-2 hover:bg-zinc-700 text-white border border-red-500 rounded">
                            Lülita 2FA välja
                        </button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showQrCode">
                        <button class="px-3 py-2 bg-zinc-600 hover:bg-zinc-700 text-white border border-zinc-700 rounded shadow">
                            Näita QR-koodi
                        </button>
                    </x-confirms-password>

                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <button class="px-3 py-2 hover:bg-zinc-700 text-white border border-red-500 rounded">
                            Lülita 2FA välja
                        </button>
                    </x-confirms-password>
                @endif
            @endif
        </div>
    </x-slot>
</x-action-section>
