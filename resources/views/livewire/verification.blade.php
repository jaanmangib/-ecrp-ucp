<div class="min-h-screen w-screen bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto w-full px-6">

        {{-- Progress --}}
        <div class="pt-20 flex justify-center">
            <nav class="w-full" aria-label="Progress">
                <ol class="space-y-4 md:flex md:space-y-0 md:space-x-8">
                    @foreach($steps as $i => $label)
                        <li class="md:flex-1" wire:key="step-{{ $i }}">
                            <div class="pl-4 py-2 flex flex-col border-l-4 md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4
                                {{ $i === $stepIndex ? 'border-indigo-600' : 'border-gray-700 hover:border-gray-600' }}">
                                <span class="text-xs font-semibold uppercase {{ $i === $stepIndex ? 'text-indigo-400' : 'text-gray-400' }}">
                                    Samm {{ $i+1 }}
                                </span>
                                <span class="text-sm font-medium text-gray-200">{{ $label }}</span>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </nav>
        </div>

        {{-- Content --}}
        <div class="flex justify-center items-center pt-10 pb-20">
            <div class="w-full">
                @php
                    $u = auth()->user();
                    $discordConnected = !empty($u->discord_id);
                    $steamConnected = !empty($u->steam_id64) || !empty($u->steam_hex);
                @endphp

                {{-- Kui RP test pole vajalik -> Discord/Steam samm --}}
                @if(!$u->requires_rp_test)

                    <div class="bg-gray-800/60 border border-white/10 rounded-xl p-6">
                        <h2 class="text-xl font-semibold">
                            {{ !$discordConnected ? 'Discordi ühendamine' : (!$steamConnected ? 'Steami ühendamine' : 'Verifitseerimine valmis') }}
                        </h2>

                        <p class="text-gray-300 mt-2">
                            RP test on sinu kasutajal vahele jäetud (requires_rp_test = 0).
                            Järgmised sammud: Discord → Steam.
                        </p>

                        <div class="mt-6 border-t border-white/10 pt-6">
                            @if($discordConnected)
                                <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
                                    <div>
                                        <div class="text-lg font-semibold text-emerald-300">Discord ühendatud ✅</div>
                                        <div class="text-gray-300 text-sm mt-1">
                                            Konto:
                                            <span class="text-white font-semibold">{{ $u->discord_username ?? $u->discord_id }}</span>
                                        </div>
                                        <div class="text-gray-400 text-xs mt-1">
                                            Ühendatud: {{ optional($u->discord_connected_at)->diffForHumans() }}
                                        </div>
                                    </div>

                                    <div class="text-sm text-gray-300 sm:text-right">
                                        @if(!$steamConnected)
                                            Järgmine samm: Steam (kohustuslik)
                                        @else
                                            Kõik tehtud ✅
                                        @endif
                                    </div>
                                </div>

                                {{-- Steam connect (kohustuslik) --}}
                                @if(!$steamConnected)
                                    <div class="mt-6 bg-black/20 border border-white/10 rounded-lg p-5">
                                        <div class="text-lg font-semibold text-white">Ühenda Steam (kohustuslik)</div>
                                        <div class="text-gray-300 text-sm mt-1">
                                            Steam ühendamine käib Steam loginiga (OpenID). Me salvestame SteamID64 + steam:HEX automaatselt.
                                        </div>

                                        <div class="mt-4 flex flex-col sm:flex-row gap-3">
                                            <a
                                                href="{{ route('steam.redirect') }}"
                                                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-md bg-indigo-600 hover:bg-indigo-700 font-semibold"
                                            >
                                                Ühenda Steam
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M13 7h8m0 0v8m0-8L11 17"/>
                                                </svg>
                                            </a>

                                            @if(session('success'))
                                                <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-200 rounded-lg px-4 py-2.5 text-sm">
                                                    {{ session('success') }}
                                                </div>
                                            @endif

                                            @if(session('error'))
                                                <div class="bg-red-500/10 border border-red-500/30 text-red-200 rounded-lg px-4 py-2.5 text-sm">
                                                    {{ session('error') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-6 bg-emerald-500/10 border border-emerald-500/30 rounded-lg p-5">
                                        <div class="text-lg font-semibold text-emerald-200">Steam ühendatud ✅</div>
                                        <div class="text-gray-200 text-sm mt-1">
                                            HEX: <span class="text-white font-semibold">{{ $u->steam_hex }}</span>
                                        </div>
                                        <div class="text-gray-300 text-xs mt-1">
                                            Ühendatud: {{ optional($u->steam_connected_at)->diffForHumans() }}
                                        </div>

                                        @if($this->allDone)
                                            <div class="mt-5">
                                                <a href="{{ route('dashboard') }}"
                                                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-md bg-emerald-600 hover:bg-emerald-700 font-semibold">
                                                    Edasi Dashboardi
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M13 7h8m0 0v8m0-8L11 17"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                            @else
                                <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
                                    <div>
                                        <div class="text-lg font-semibold text-white">Ühenda Discord</div>
                                        <div class="text-gray-300 text-sm mt-1">
                                            Ühendamisel lisatakse sind automaatselt Discordi serverisse ja antakse “whitelisted” roll.
                                        </div>
                                    </div>

                                    <a href="{{ route('discord.redirect') }}"
                                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-md bg-indigo-600 hover:bg-indigo-700 font-semibold">
                                        Ühenda Discord
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M13 7h8m0 0v8m0-8L11 17"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                @else

                    {{-- RP test cooldown / fail screen --}}
                    @if($u->rp_test_failed_until && now()->lt($u->rp_test_failed_until))
                        <div class="bg-gray-800/60 border border-white/10 rounded-xl p-8 text-center">
                            <svg class="w-16 h-16 mx-auto text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>

                            <h2 class="text-xl font-semibold mt-4">Kahjuks ei pääsenud sa testist läbi.</h2>
                            <p class="text-gray-300 mt-2">
                                Uuesti saad proovida <span class="text-white font-semibold">{{ $nextTestIn }}</span> pärast.
                            </p>

                            @if(!empty($failedQuestions))
                                <div class="mt-6 text-left max-w-2xl mx-auto bg-red-500/10 border border-red-500/30 rounded-lg p-4">
                                    <div class="text-sm text-red-200 font-semibold mb-2">
                                        Valesid küsimusi: {{ count($failedQuestions) }}
                                    </div>
                                    <ul class="space-y-2 text-sm text-gray-200">
                                        @foreach($failedQuestions as $t)
                                            <li class="flex gap-2" wire:key="failed-{{ md5($t) }}">
                                                <span class="text-red-400">•</span>
                                                <span>{{ $t }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                    {{-- RP test passed -> Discord/Steam samm --}}
                    @elseif($u->rp_test_passed)

                        <div class="bg-gray-800/60 border border-white/10 rounded-xl p-8">
                            <div class="flex items-center gap-4">
                                <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12l2 2 4-4m7 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h2 class="text-xl font-semibold">Rollimängu test tehtud!</h2>
                                    <p class="text-gray-300">
                                        Järgmised sammud: Discord → Steam (kohustuslik).
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6 border-t border-white/10 pt-6">
                                @if($discordConnected)
                                    <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
                                        <div>
                                            <div class="text-lg font-semibold text-emerald-300">Discord ühendatud ✅</div>
                                            <div class="text-gray-300 text-sm mt-1">
                                                Konto: <span class="text-white font-semibold">{{ $u->discord_username ?? $u->discord_id }}</span>
                                            </div>
                                            <div class="text-gray-400 text-xs mt-1">
                                                Ühendatud: {{ optional($u->discord_connected_at)->diffForHumans() }}
                                            </div>
                                        </div>

                                        <div class="text-sm text-gray-300 sm:text-right">
                                            @if(!$steamConnected)
                                                Järgmine samm: Steam (kohustuslik)
                                            @else
                                                Kõik tehtud ✅
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Steam connect (kohustuslik) --}}
                                    @if(!$steamConnected)
                                        <div class="mt-6 bg-black/20 border border-white/10 rounded-lg p-5">
                                            <div class="text-lg font-semibold text-white">Ühenda Steam (kohustuslik)</div>
                                            <div class="text-gray-300 text-sm mt-1">
                                                Steam ühendamine käib Steam loginiga (OpenID). Me salvestame SteamID64 + steam:HEX automaatselt.
                                            </div>

                                            <div class="mt-4 flex flex-col sm:flex-row gap-3">
                                                <a
                                                    href="{{ route('steam.redirect') }}"
                                                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-md bg-indigo-600 hover:bg-indigo-700 font-semibold"
                                                >
                                                    Ühenda Steam
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M13 7h8m0 0v8m0-8L11 17"/>
                                                    </svg>
                                                </a>

                                                @if(session('success'))
                                                    <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-200 rounded-lg px-4 py-2.5 text-sm">
                                                        {{ session('success') }}
                                                    </div>
                                                @endif

                                                @if(session('error'))
                                                    <div class="bg-red-500/10 border border-red-500/30 text-red-200 rounded-lg px-4 py-2.5 text-sm">
                                                        {{ session('error') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-6 bg-emerald-500/10 border border-emerald-500/30 rounded-lg p-5">
                                            <div class="text-lg font-semibold text-emerald-200">Steam ühendatud ✅</div>
                                            <div class="text-gray-200 text-sm mt-1">
                                                HEX: <span class="text-white font-semibold">{{ $u->steam_hex }}</span>
                                            </div>
                                            <div class="text-gray-300 text-xs mt-1">
                                                Ühendatud: {{ optional($u->steam_connected_at)->diffForHumans() }}
                                            </div>

                                            @if($this->allDone)
                                                <div class="mt-5">
                                                    <a href="{{ route('dashboard') }}"
                                                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-md bg-emerald-600 hover:bg-emerald-700 font-semibold">
                                                        Edasi Dashboardi
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M13 7h8m0 0v8m0-8L11 17"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                @else
                                    <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
                                        <div>
                                            <div class="text-lg font-semibold text-white">Ühenda Discord</div>
                                            <div class="text-gray-300 text-sm mt-1">
                                                Ühendamisel lisatakse sind automaatselt Discordi serverisse ja antakse “whitelisted” roll.
                                            </div>
                                        </div>

                                        <a href="{{ route('discord.redirect') }}"
                                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-md bg-indigo-600 hover:bg-indigo-700 font-semibold">
                                            Ühenda Discord
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M13 7h8m0 0v8m0-8L11 17"/>
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                    {{-- RP test küsimused --}}
                    @else
                        <div class="bg-gray-800/60 border border-white/10 rounded-xl p-6">
                            <h2 class="text-lg font-semibold text-gray-100">
                                Serveriga liitumiseks on vaja sooritada rollimängu test (8 küsimust).
                            </h2>

                            @error('test')
                                <div class="mt-4 bg-red-500/10 border border-red-500/30 text-red-200 rounded-lg p-3 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror

                            @php $q = $questions[$activeQuestion] ?? null; @endphp

                            @if($q)
                                <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6" wire:key="question-{{ $q['id'] }}">
                                    <div class="lg:col-span-2">
                                        <div class="text-xl font-semibold text-white">
                                            {{ $q['text'] }}
                                        </div>

                                        <div class="mt-5 space-y-3">
                                            @foreach($q['answers'] as $a)
                                                @php
                                                    $qid = $q['id'];
                                                    $checked = in_array($a['id'], $picked[$qid] ?? [], true);
                                                @endphp

                                                <label
                                                    wire:key="answer-{{ $q['id'] }}-{{ $a['id'] }}"
                                                    class="flex items-start gap-3 p-3 rounded-lg border border-white/10 bg-black/20 hover:bg-black/30 cursor-pointer"
                                                >
                                                    <input
                                                        type="checkbox"
                                                        class="mt-1 h-4 w-4 rounded border-gray-500 bg-gray-700 text-indigo-600 focus:ring-indigo-500"
                                                        @checked($checked)
                                                        wire:click="toggleAnswer({{ $qid }}, {{ $a['id'] }})"
                                                    >
                                                    <span class="text-gray-200">{{ $a['text'] }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="lg:col-span-1 flex flex-col items-center justify-between">
                                        <div class="text-center">
                                            <div class="text-2xl font-semibold text-gray-200">
                                                Küsimus {{ $activeQuestion+1 }}/{{ count($questions) }}
                                            </div>

                                            <div class="mt-4 flex gap-3 justify-center">
                                                <button
                                                    type="button"
                                                    class="px-4 py-2 rounded-md bg-gray-800 border border-white/10 disabled:opacity-40"
                                                    wire:click="previousQuestion"
                                                    @disabled($activeQuestion === 0)
                                                >
                                                    ←
                                                </button>

                                                @if($activeQuestion < count($questions)-1)
                                                    <button
                                                        type="button"
                                                        class="px-4 py-2 rounded-md bg-gray-800 border border-white/10"
                                                        wire:click="nextQuestion"
                                                    >
                                                        →
                                                    </button>
                                                @else
                                                    <button
                                                        type="button"
                                                        class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 font-semibold flex items-center gap-2"
                                                        wire:click="submitTest"
                                                    >
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M9 12l2 2 4-4m7 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        Valmis
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mt-8 w-full">
                                            <div class="flex justify-center gap-2">
                                                @for($i=0; $i<count($questions); $i++)
                                                    <span
                                                        wire:key="dot-{{ $i }}"
                                                        class="h-2.5 w-2.5 rounded-full {{ $i === $activeQuestion ? 'bg-indigo-500' : 'bg-gray-600' }}"
                                                    ></span>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
