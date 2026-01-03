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

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Unustasid parooli? Pole probleemi. Sisesta enda email ning saadame sulle emaili parooli taastamiseks.') }}
        </div>

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input
                    id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Saada link') }}
                </x-button>
            </div>
        </form>

    </x-authentication-card>
</x-guest-layout>
