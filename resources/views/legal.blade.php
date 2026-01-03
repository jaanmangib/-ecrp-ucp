<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Eclipse RP — Reeglid & Tingimused' }}</title>

    {{-- Jetstream / Vite CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <style>
        body { font-family: Nunito, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; }

        /* Taustapildi “pan” animatsioon (valikuline). Kui pilti pole, jääb tume gradient. */
        #background img{
            position:absolute;
            inset:0;
            width:100%;
            height:100%;
            object-fit:cover;
            opacity:.18;
            transform: scale(1.3);
            animation: animatedBackground 22s linear infinite;
        }
        @keyframes animatedBackground { 0% { transform: translateX(0) scale(1.3);} 100% { transform: translateX(-300px) scale(1.3);} }
    </style>
</head>

<body class="antialiased bg-gray-700 text-gray-100">
<div class="relative min-h-screen bg-gray-800 overflow-hidden">

    {{-- Background --}}
    <div id="background" class="absolute inset-0 -z-10">
        {{-- Pane oma pilt siia (public/images/legal-bg.jpg) vms --}}
        <img src="{{ asset('images/legal-bg.jpg') }}" alt="" onerror="this.style.display='none'">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900/90 via-gray-900/70 to-gray-800/90"></div>
    </div>

    {{-- Top bar --}}
    <div class="max-w-7xl mx-auto pt-8 pb-2 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('ecrp.png') }}" alt="ECRP" class="h-10 w-10 rounded-md object-cover ring-1 ring-white/10">
                <div class="leading-tight">
                    <div class="text-white font-bold text-lg group-hover:text-indigo-300 transition">Eclipse RP</div>
                    <div class="text-gray-300 text-sm">Reeglid & teenustingimused</div>
                </div>
            </a>

            <div class="flex items-center gap-2">
                <a href="{{ url('/reeglid') }}"
                   class="px-3 py-2 rounded-md text-sm font-semibold border border-white/10 hover:border-indigo-400/40 hover:bg-white/5 {{ request()->is('reeglid') ? 'bg-white/5 border-indigo-400/50' : '' }}">
                    Reeglid
                </a>
                <a href="{{ url('/tingimused') }}"
                   class="px-3 py-2 rounded-md text-sm font-semibold border border-white/10 hover:border-indigo-400/40 hover:bg-white/5 {{ request()->is('tingimused') ? 'bg-white/5 border-indigo-400/50' : '' }}">
                    Tingimused
                </a>

                @auth
                    <a href="{{ route('dashboard') }}"
                       class="ml-2 px-4 py-2 rounded-md text-sm font-bold bg-indigo-600 hover:bg-indigo-700">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="ml-2 px-4 py-2 rounded-md text-sm font-bold bg-gray-900/80 hover:bg-black border border-white/10">
                        Logi sisse
                    </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="text-white">
        <div class="max-w-7xl mx-auto pt-8 pb-6 px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-4 lg:gap-8">

                {{-- Left column --}}
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-200 border-l-4 pl-3 border-l-indigo-500">
                        {{ $headline ?? 'Reeglid & Tingimused' }}
                    </h1>

                    <p class="mt-4 text-base sm:text-lg text-gray-100">
                        Viimati uuendatud
                        <span class="font-semibold text-indigo-400">01.01.2026</span>.
                    </p>

                    <div class="mt-6 text-sm text-gray-300 space-y-2">
                        <p class="text-gray-400">
                            Need reeglid kehtivad kõigile Eclipse RP mängijatele.
                        </p>
                        <p class="text-gray-400">
                            Probleemide või küsimuste korral võta ühendust meeskonnaga meie discordi serveris ticketi teel.
                        </p>

                        <a href="https://discord.gg/Z9Mxu72zZ6" target="_blank"
                           class="inline-flex items-center justify-center px-4 py-2 rounded-md font-bold bg-gray-900/80 hover:bg-black border border-white/10">
                            Liitu Discordiga
                        </a>
                    </div>
                </div>

                {{-- Right column --}}
                <div class="mt-10 lg:mt-0 lg:col-span-3">

                    {{-- Notice --}}
                    <div class="border-l-4 border-yellow-400 bg-yellow-50/95 text-gray-900 p-4 mb-6 rounded-md">
                        <div class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-yellow-500 mt-0.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                            </svg>

                            <div class="text-sm">
                                <p class="font-bold">Oluline</p>
                                <p class="mt-1">
                                    Reeglite mitteteadmine ei vabasta vastutusest. Meeskonnal on õigus rakendada meetmeid,
                                    kui mängukogemus kannatab või reeglite eesmärgist mööda hiilitakse.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Sections --}}
                    <div class="space-y-10">

                        {{-- REEGLID --}}
                        @if(($page ?? 'rules') === 'rules')
                            <section>
                                <h2 class="text-xl font-bold text-gray-200 border-l-4 pl-3 border-l-indigo-500">
                                    Serveri reeglid
                                </h2>

                                <dl class="mt-6 space-y-10">
                                    <div>
                                        <dt class="text-lg font-semibold text-gray-300">
                                            Reegel 0: <span class="text-indigo-400">Üldine</span>
                                        </dt>
                                        <dd class="mt-2 text-gray-300">
                                            <ol class="list-decimal ml-5 space-y-2 text-justify">
                                                <li>Eeldame tervet mõistust ja heausksust. Tegevused, mis rikuvad mängukultuuri, võivad olla karistatavad ka siis, kui neid pole “täpselt” reeglites kirjas.</li>
                                                <li>Reeglite tõlgendamisel on prioriteet reegli eesmärk ja serveri keskkond.</li>
                                                <li>Admini ootamine ei lõpeta olukorda. Viige RP olukord lõpuni ja teavitage vajadusel meeskonda.</li>
                                                <li>RMT (serveri vara/raha müük/ost/vahetus väljaspool serverit) on keelatud.</li>
                                            </ol>
                                        </dd>
                                    </div>

                                    <div>
                                        <dt class="text-lg font-semibold text-gray-300">
                                            Reegel 1: <span class="text-indigo-400">Powergaming</span>
                                        </dt>
                                        <dd class="mt-2 text-gray-300">
                                            <ul class="list-disc ml-5 space-y-2 text-justify">
                                                <li>Ebareaalne või “võimatu” tegevus, mis annab ebaausa eelise, on keelatud.</li>
                                                <li>Relvaga sihtimisel on kohustuslik hirmu RP ja olukorrale allumine (mõistlikkuse piires).</li>
                                            </ul>
                                        </dd>
                                    </div>

                                    <div>
                                        <dt class="text-lg font-semibold text-gray-300">
                                            Reegel 2: <span class="text-indigo-400">Metagaming</span>
                                        </dt>
                                        <dd class="mt-2 text-gray-300">
                                            <ul class="list-disc ml-5 space-y-2 text-justify">
                                                <li>OC info kasutamine IC tegevustes on keelatud (Discord, stream, sõbra info jne).</li>
                                                <li>Hääle järgi tuvastamine ja info “väljastpoolt” rolli on keelatud.</li>
                                            </ul>
                                        </dd>
                                    </div>

                                    <div>
                                        <dt class="text-lg font-semibold text-gray-300">
                                            Reegel 3: <span class="text-indigo-400">Deathmatch</span>
                                        </dt>
                                        <dd class="mt-2 text-gray-300">
                                            <ul class="list-disc ml-5 space-y-2 text-justify">
                                                <li>Ilma veenva RP põhjuseta vigastamine/tapmine/kahju tekitamine on keelatud.</li>
                                                <li>Revenge kill on keelatud — pärast surma on eelnev olukord unustatud.</li>
                                                <li>V-DM (sõidukiga “koksamine”) on keelatud.</li>
                                            </ul>
                                        </dd>
                                    </div>

                                    <div>
                                        <dt class="text-lg font-semibold text-gray-300">
                                            Reegel 4: <span class="text-indigo-400">Safezone</span>
                                        </dt>
                                        <dd class="mt-2 text-gray-300">
                                            <ul class="list-disc ml-5 space-y-2 text-justify">
                                                <li>Rahvarohketes piirkondades on röövimine/varastamine/tulistamine ilma loata keelatud.</li>
                                                <li>Kui olukord algas väljaspool safezone’i, võib see mõistlikult jätkuda ka safezone’is sama episoodi jooksul.</li>
                                            </ul>
                                        </dd>
                                    </div>

                                    <div>
                                        <dt class="text-lg font-semibold text-gray-300">
                                            Reegel 5: <span class="text-indigo-400">Röövid & pettused</span>
                                        </dt>
                                        <dd class="mt-2 text-gray-300">
                                            <ul class="list-disc ml-5 space-y-2 text-justify">
                                                <li>Röövimiseks peab olema veenev RP põhjus (ainult “tahan raha” ei ole piisav).</li>
                                                <li>Pettused, mis võtavad ära vara/sõidukid/kinnisvara ilma RP-ta, on keelatud.</li>
                                                <li>Avaliku teenistuja varustuse müümine/röövimine/varastamine on keelatud.</li>
                                            </ul>
                                        </dd>
                                    </div>
                                </dl>
                            </section>
                        @endif

                        {{-- TINGIMUSED --}}
                        @if(($page ?? 'rules') === 'tos')
                            <section>
                                <h2 class="text-xl font-bold text-gray-200 border-l-4 pl-3 border-l-indigo-500">
                                    Teenustingimused
                                </h2>

                                <div class="mt-6 text-gray-300 space-y-4 text-justify">
                                    <p>
                                        Käesolevad tingimused reguleerivad Eclipse RP teenuse kasutamist (server, veebileht, Discord ja seotud teenused).
                                        Teenust kasutades nõustud nende tingimustega.
                                    </p>

                                    <h3 class="text-lg font-semibold text-gray-200 mt-6">1. Konto ja ligipääs</h3>
                                    <ul class="list-disc ml-5 space-y-2">
                                        <li>Vastutad oma konto turvalisuse eest.</li>
                                        <li>Meeskond võib piirata ligipääsu (nt. reeglite rikkumine, petmine, toksiline käitumine).</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-gray-200 mt-6">2. Käitumine ja sisu</h3>
                                    <ul class="list-disc ml-5 space-y-2">
                                        <li>Keelatud on solvamine, diskrimineerimine, doxximine, ahistamine.</li>
                                        <li>Keelatud on cheatid, exploitid, bug abuse, kolmandate osapoolte “advantage” tarkvara.</li>
                                        <li>Keelatud on RMT (serveri vara/raha müük/ost/vahetus väljaspool serverit).</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-gray-200 mt-6">3. Sanktsioonid</h3>
                                    <p>
                                        Reeglite või tingimuste rikkumisel võib meeskond rakendada hoiatust, ajutist keeldu või püsivat bänni.
                                        Otsused võivad sõltuda olukorra kontekstist ja korduvatest rikkumistest.
                                    </p>

                                    <h3 class="text-lg font-semibold text-gray-200 mt-6">4. Andmed ja privaatsus</h3>
                                    <ul class="list-disc ml-5 space-y-2">
                                        <li>Kasutame kontoga seotud andmeid teenuse pakkumiseks (nt email, kasutajanimi, logid).</li>
                                        <li>Võime talletada tehnilisi logisid (ühendused, vead, turbeintsidendid) kuritarvituste ennetamiseks.</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-gray-200 mt-6">5. Vastutuse piirang</h3>
                                    <p>
                                        Teenus on “nagu on”. Me ei garanteeri katkestusteta tööd (uuendused, hooldus, DDoS jne).
                                        Virtuaalne vara võib muutuda (wipe, balanss, uued süsteemid).
                                    </p>

                                    <h3 class="text-lg font-semibold text-gray-200 mt-6">6. Muudatused</h3>
                                    <p>
                                        Võime tingimusi ja reegleid ajakohastada. “Viimati uuendatud” kuupäev näitab viimast versiooni.
                                    </p>
                                </div>
                            </section>
                        @endif
                    </div>

                    <div class="mt-10 pt-6 border-t border-white/10 text-sm text-gray-400">
                        Lehekülg arendatud <span class="font-semibold text-gray-200">jaanmangib.dev</span> poolt.
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
</body>
</html>
