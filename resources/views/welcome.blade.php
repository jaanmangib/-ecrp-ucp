{{-- resources/views/welcome.blade.php --}}
<!doctype html>
<html lang="et" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Eclipse RP') }} — Eesti GTA 5 RP server</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Jetstream / Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; }

        /* parema poole taustapiltide animatsioon + vahetus */
        #bg img{
            position:absolute;
            inset:0;
            width:100%;
            height:100%;
            object-fit:cover;
            transform: scale(1.25);
            animation: bg-pan 20s linear;
            opacity: 0;
            transition: opacity .9s ease;
            will-change: transform, opacity;
        }
        @keyframes bg-pan {
            0%   { transform: translateX(0) scale(1.25); }
            100% { transform: translateX(-240px) scale(1.25); }
        }

        .soft-card { box-shadow: 0 20px 50px rgba(0,0,0,.45); }
    </style>
</head>

<body class="antialiased bg-zinc-700 text-white">
@php
    // === MUUDA NEED OMAKS ===
    $brand    = config('app.name', 'Eclipse RP');
    $tagline1 = 'Eesti RP server';
    $tagline2 = 'Liitu ja alusta täna';

    $connectUrl = 'fivem://connect/server.eclipserp.ee';  // muuda
    $discordUrl = 'https://discord.gg/2BWpPu4K5t';     // muuda

    // Pane pildid: public/images/background1.jpg jne
    $bgImages = [
        '/images/background1.jpg',
        '/images/background2.jpg',
        '/images/background3.jpg',
        '/images/background4.jpg',
        '/images/background5.jpg'
    ];

    // Jetstream route’d (kui sul on register välja lülitatud, siis Route::has('register') on false)
    $loginUrl     = Route::has('login') ? route('login') : url('/login');
    $registerUrl  = Route::has('register') ? route('register') : url('/register');
    $dashboardUrl = Route::has('dashboard') ? route('dashboard') : url('/dashboard');
@endphp

<div class="font-sans">
    <div class="relative overflow-hidden bg-zinc-800 min-h-[100vh] lg:min-h-screen">

        <div class="max-w-7xl mx-auto h-full">
            <div class="relative z-10 h-full pb-10 bg-zinc-800 lg:max-w-2xl lg:w-full lg:pb-0">

                {{-- diagonaalne “lõige” paremale --}}
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-56 text-zinc-800 translate-x-1/2"
                     fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100"></polygon>
                </svg>

                <div class="relative pt-6 px-4 sm:px-6 lg:px-8"></div>

                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-16">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">{{ $brand }}</span>
                            <span class="block text-indigo-300 xl:inline">Roleplay</span>
                        </h1>

                        <p class="mt-3 text-base text-zinc-200/90 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            {{ $tagline1 }} — {{ $tagline2 }}. Registreerimine on kiire ja automaatne.
                        </p>

                        {{-- CTA nupud --}}
                        <div class="mt-6 flex flex-col sm:flex-row gap-3 sm:justify-center lg:justify-start">
                            @guest
                                @if (Route::has('register'))
                                    <a href="{{ $registerUrl }}"
                                       class="inline-flex items-center justify-center px-5 py-3 rounded-md font-extrabold bg-indigo-600 hover:bg-indigo-700">
                                        Loo konto
                                        <span class="flex relative h-3 w-3 ml-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-zinc-300 opacity-60"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-zinc-200"></span>
                                        </span>
                                    </a>
                                @endif
                            @endguest

                            <a href="{{ $connectUrl }}"
                               class="inline-flex items-center justify-center px-5 py-3 rounded-md font-extrabold bg-emerald-600 hover:bg-emerald-700">
                                Ühine serveriga
                            </a>

                            <a href="{{ $discordUrl }}" target="_blank" rel="noopener"
                               class="inline-flex items-center justify-center px-5 py-3 rounded-md font-extrabold bg-zinc-900 hover:bg-black border border-white/10">
                                Liitu discordiga
                            </a>
                        </div>
                    </div>

                    {{-- PROTSESS KAART --}}
                    <div class="mt-12 bg-zinc-900 mx-auto lg:mr-auto lg:ml-0 overflow-hidden soft-card rounded-lg w-11/12 sm:w-[26rem]">
                        <section aria-labelledby="how-title">
                            <div class="bg-zinc-100 px-4 py-5 sm:rounded-lg sm:px-6 text-zinc-900">
                                <h2 id="how-title" class="text-lg font-extrabold">Tahad mängida?</h2>

                                <p class="text-sm text-zinc-600 leading-tight mt-2">
                                    Et hoida server puhas topeltkontodest ja “trollimisest”, on liitumisel väike kontroll.
                                </p>

                                <p class="text-sm text-zinc-600 leading-tight mt-3">
                                    Kogu protsess on <span class="font-bold text-zinc-900">automaatne</span> ja võtab tavaliselt
                                    <span class="font-bold text-zinc-900">alla 5 minuti</span>.
                                </p>

                                <div class="mt-6 flow-root">
                                    <ol class="overflow-hidden">
                                        {{-- 1 --}}
                                        <li class="relative pb-8">
                                            <div class="-ml-px absolute mt-0.5 top-4 left-4 w-0.5 h-full bg-zinc-300" aria-hidden="true"></div>
                                            <div class="relative flex items-start group">
                                                <span class="h-9 flex items-center" aria-hidden="true">
                                                    <span class="relative z-10 w-8 h-8 flex items-center justify-center bg-white border-2 border-zinc-300 rounded-full group-hover:border-zinc-400">
                                                        <span class="h-2.5 w-2.5 rounded-full bg-zinc-300 group-hover:bg-zinc-400"></span>
                                                    </span>
                                                </span>
                                                <span class="ml-4 min-w-0 flex flex-col">
                                                    <span class="text-xs font-extrabold uppercase tracking-wide text-zinc-600">RP test</span>
                                                    <span class="text-sm text-zinc-600">Lühike test rollimängu põhitõdedest.</span>
                                                </span>
                                            </div>
                                        </li>

                                        {{-- 2 --}}
                                        <li class="relative pb-8">
                                            <div class="-ml-px absolute mt-0.5 top-4 left-4 w-0.5 h-full bg-zinc-300" aria-hidden="true"></div>
                                            <div class="relative flex items-start group">
                                                <span class="h-9 flex items-center" aria-hidden="true">
                                                    <span class="relative z-10 w-8 h-8 flex items-center justify-center bg-white border-2 border-zinc-300 rounded-full group-hover:border-zinc-400">
                                                        <span class="h-2.5 w-2.5 rounded-full bg-zinc-300 group-hover:bg-zinc-400"></span>
                                                    </span>
                                                </span>
                                                <span class="ml-4 min-w-0 flex flex-col">
                                                    <span class="text-xs font-extrabold uppercase tracking-wide text-zinc-600">Discord</span>
                                                    <span class="text-sm text-zinc-600">Ühenda oma Discordi konto.</span>
                                                </span>
                                            </div>
                                        </li>

                                        {{-- 3 --}}
                                        <li class="relative pb-8">
                                            <div class="-ml-px absolute mt-0.5 top-4 left-4 w-0.5 h-full bg-zinc-300" aria-hidden="true"></div>
                                            <div class="relative flex items-start group">
                                                <span class="h-9 flex items-center" aria-hidden="true">
                                                    <span class="relative z-10 w-8 h-8 flex items-center justify-center bg-white border-2 border-zinc-300 rounded-full group-hover:border-zinc-400">
                                                        <span class="h-2.5 w-2.5 rounded-full bg-zinc-300 group-hover:bg-zinc-400"></span>
                                                    </span>
                                                </span>
                                                <span class="ml-4 min-w-0 flex flex-col">
                                                    <span class="text-xs font-extrabold uppercase tracking-wide text-zinc-600">Steam</span>
                                                    <span class="text-sm text-zinc-600">Ühenda Steami kasutaja.</span>
                                                </span>
                                            </div>
                                        </li>

                                        {{-- DONE --}}
                                        <li class="relative">
                                            <div class="relative flex items-start group">
                                                <span class="h-9 flex items-center">
                                                    <span class="relative z-10 w-8 h-8 flex items-center justify-center bg-indigo-600 rounded-full group-hover:bg-indigo-700">
                                                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </span>
                                                </span>
                                                <span class="ml-4 min-w-0 flex flex-col">
                                                    <span class="text-xs font-extrabold uppercase tracking-wide text-zinc-600">VALMIS</span>
                                                    <span class="text-sm text-zinc-600">Saad sisse logida ja serveriga liituda.</span>
                                                </span>
                                            </div>
                                        </li>
                                    </ol>
                                </div>

                                {{-- Alumised nupud: guest => Login / Register, auth => Dashboard --}}
                                <div class="mt-6 flex flex-col gap-2">
                                    @guest
                                        @if (Route::has('register'))
                                            <a href="{{ $registerUrl }}"
                                               class="inline-flex items-center justify-center px-4 py-2 rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 font-extrabold">
                                                Alusta
                                            </a>
                                        @endif

                                        @if (Route::has('login'))
                                            <a href="{{ $loginUrl }}"
                                               class="inline-flex items-center justify-center px-4 py-2 rounded-md text-zinc-900 bg-white hover:bg-zinc-200 font-extrabold border border-zinc-200">
                                                Logi sisse
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ $dashboardUrl }}"
                                           class="inline-flex items-center justify-center px-4 py-2 rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 font-extrabold">
                                            Mine dashboardi
                                        </a>
                                    @endguest
                                </div>
                            </div>
                        </section>
                    </div>

                    <p class="mt-6 text-sm text-white/50 sm:text-center lg:text-left">
                        Lehekülg arendatud <span class="font-bold text-white/70">jaanmangib.dev</span> poolt.
                    </p>
                </main>
            </div>
        </div>

        {{-- PAREM POOL: background slideshow + login/dashboard nupp --}}
        <div class="hidden lg:block lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 relative" id="bg">
            <div class="absolute right-10 top-10 z-10">
                @auth
                    <a href="{{ $dashboardUrl }}"
                       class="inline-flex items-center px-4 py-2 rounded-md text-white bg-zinc-900/90 hover:bg-black border border-white/10 font-extrabold">
                        Dashboard
                    </a>
                @else
                    @if (Route::has('login'))
                        <a href="{{ $loginUrl }}"
                           class="inline-flex items-center px-4 py-2 rounded-md text-white bg-zinc-900/90 hover:bg-black border border-white/10 font-extrabold">
                            Logi sisse
                        </a>
                    @endif
                @endauth
            </div>

            {{-- overlay --}}
            <div class="absolute inset-0 bg-gradient-to-l from-black/10 via-black/30 to-zinc-800"></div>

            @foreach($bgImages as $i => $src)
                <img id="bg{{ $i }}" src="{{ $src }}" alt="Background {{ $i }}" style="opacity: {{ $i === 0 ? 1 : 0 }};">
            @endforeach
        </div>
    </div>
</div>

<script>
(() => {
    const container = document.getElementById('bg');
    if (!container) return;

    const images = Array.from(container.querySelectorAll('img'));
    if (!images.length) return;

    let last = 0;
    let used = [];

    function restartAnim(el){
        el.style.animation = 'none';
        el.offsetHeight; // reflow
        el.style.animation = null;
    }

    function pickIndex(){
        if (used.length === images.length) used = [];
        let idx = Math.floor(Math.random() * images.length);
        while (used.includes(idx) || idx === last) idx = Math.floor(Math.random() * images.length);
        used.push(idx);
        last = idx;
        return idx;
    }

    function showNext(){
        const idx = pickIndex();
        images.forEach((img, i) => {
            img.style.opacity = (i === idx) ? '1' : '0';
            if (i === idx) restartAnim(img);
        });
    }

    setInterval(showNext, 9000);
})();
</script>
</body>
</html>
