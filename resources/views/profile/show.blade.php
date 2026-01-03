<x-layouts.ucp title="Profiil">
    <div class="w-full">
        {{-- FULL-WIDTH, sama vibe: bg-zinc-900 + border-zinc-700 + shadow --}}
        <div class="w-full space-y-2">

            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <div class="p-4 bg-zinc-900 border border-zinc-700 rounded shadow">
                    @livewire('profile.update-profile-information-form')
                </div>
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="p-4 bg-zinc-900 border border-zinc-700 rounded shadow">
                    @livewire('profile.update-password-form')
                </div>
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="p-4 bg-zinc-900 border border-zinc-700 rounded shadow">
                    @livewire('profile.two-factor-authentication-form', ['confirmableId' => 'two-factor-auth'])
                </div>
            @endif

            <div class="p-4 bg-zinc-900 border border-zinc-700 rounded shadow">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="p-4 bg-zinc-900 border border-zinc-700 rounded shadow">
                    @livewire('profile.delete-user-form')
                </div>
            @endif

        </div>
    </div>
</x-layouts.ucp>
