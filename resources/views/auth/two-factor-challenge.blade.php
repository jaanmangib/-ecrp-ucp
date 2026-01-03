<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <a href="{{ url('/') }}" class="flex justify-center">
                <img
                    src="{{ asset('images/ecrp.png') }}"
                    alt="ECRP"
                    class="h-12 w-auto"
                >
            </a>
        </x-slot>

        <div x-data="{ recovery: false }">
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400" x-show="! recovery">
                {{ __('Palun kinnita ligipääs oma kontole, sisestades autentimisrakenduse poolt antud koodi.') }}
            </div>

            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400" x-cloak x-show="recovery">
                {{ __('Palun kinnita ligipääs oma kontole, sisestades ühe hädaolukorra taastamiskoodidest.') }}
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf

                <div class="mt-4" x-show="! recovery">
                    <x-label for="code" value="{{ __('Kood') }}" />
                    <x-input
                        id="code"
                        class="block mt-1 w-full"
                        type="text"
                        inputmode="numeric"
                        name="code"
                        autofocus
                        x-ref="code"
                        autocomplete="one-time-code"
                    />
                </div>

                <div class="mt-4" x-cloak x-show="recovery">
                    <x-label for="recovery_code" value="{{ __('Taastamiskood') }}" />
                    <x-input
                        id="recovery_code"
                        class="block mt-1 w-full"
                        type="text"
                        name="recovery_code"
                        x-ref="recovery_code"
                        autocomplete="one-time-code"
                    />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button
                        type="button"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 underline cursor-pointer"
                        x-show="! recovery"
                        x-on:click="
                            recovery = true;
                            $nextTick(() => { $refs.recovery_code.focus() })
                        "
                    >
                        {{ __('Kasuta taastamiskoodi') }}
                    </button>

                    <button
                        type="button"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 underline cursor-pointer"
                        x-cloak
                        x-show="recovery"
                        x-on:click="
                            recovery = false;
                            $nextTick(() => { $refs.code.focus() })
                        "
                    >
                        {{ __('Kasuta autentimiskoodi') }}
                    </button>

                    <x-button class="ms-4">
                        {{ __('Logi sisse') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
