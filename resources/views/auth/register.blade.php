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

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Kasutajanimi') }}" />
                <x-input
                    id="name"
                    class="block mt-1 w-full"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required
                    autofocus
                    autocomplete="name"
                />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input
                    id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autocomplete="username"
                />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Salasõna') }}" />
                <x-input
                    id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Korda salasõna') }}" />
                <x-input
                    id="password_confirmation"
                    class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                />
            </div>

            {{-- Nõustumine reeglite ja tingimustega (KOHUSTUSLIK) --}}
            <div class="mt-4">
                <x-label for="terms">
                    <div class="flex items-start">
                        <x-checkbox name="terms" id="terms" required />

                        <div class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                            Nõustun
                            <a target="_blank" href="{{ url('/tingimused') }}"
                               class="underline hover:text-gray-900 dark:hover:text-gray-100">
                                teenustingimustega
                            </a>
                            ja
                            <a target="_blank" href="{{ url('/reeglid') }}"
                               class="underline hover:text-gray-900 dark:hover:text-gray-100">
                                serveri reeglitega
                            </a>.
                        </div>
                    </div>
                </x-label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                    href="{{ route('login') }}"
                >
                    {{ __('Kasutaja olemas?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Registreeru') }}
                </x-button>
            </div>
        </form>

    </x-authentication-card>
</x-guest-layout>
