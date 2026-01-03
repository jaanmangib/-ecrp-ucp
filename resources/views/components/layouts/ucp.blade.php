@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ? $title.' — '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #3F3F46; }
        ::-webkit-scrollbar-thumb { background: #1e1e1f; }
        ::-webkit-scrollbar-thumb:hover { background: #141414; }
    </style>
</head>

<body class="h-full bg-zinc-950 text-zinc-200 antialiased">
<div class="flex h-screen w-screen overflow-hidden">

    {{-- LEFT SIDEBAR --}}
    <aside class="w-64 bg-zinc-800 text-zinc-200 border-r border-zinc-700 flex-shrink-0">
        <div class="px-4 pt-5 pb-4 h-full flex flex-col">

            {{-- LOGO --}}
            <div class="text-center mb-4">
                <h4 class="text-white font-bold text-2xl">Eclipse RP</h4>
            </div>

            {{-- USER BLOCK (SIIN, logo all) --}}
            <div
                class="mb-4"
                x-data="{ open: false }"
                @keydown.escape.window="open = false"
            >
                <button
                    type="button"
                    class="w-full flex items-center justify-between gap-3 px-3 py-2 rounded bg-zinc-900 border border-zinc-700 hover:bg-zinc-800"
                    @click="open = !open"
                >
                    <div class="flex items-center gap-2 min-w-0">
                        <img
                            src="{{ auth()->user()->profile_photo_url }}"
                            class="w-8 h-8 rounded-full border border-zinc-700 flex-shrink-0"
                            alt="Profiil"
                        >
                        <span class="truncate text-sm">
                            {{ auth()->user()->name }}
                        </span>
                    </div>

                    <svg class="w-4 h-4 opacity-70" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8.25 9.75L12 13.5l3.75-3.75" />
                    </svg>
                </button>

                <div
                    x-show="open"
                    x-transition
                    @click.outside="open = false"
                    class="mt-1 w-full rounded border border-zinc-700 bg-zinc-900 shadow-lg overflow-hidden"
                    style="display:none;"
                >
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full px-3 py-2 text-left text-sm hover:bg-zinc-800 flex items-center gap-2"
                        >
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l-3-3m3 3l-3 3m3-3H9" />
                            </svg>
                            Logi välja
                        </button>
                    </form>
                </div>
            </div>

            {{-- NAV --}}
            <nav class="flex-1 px-1 space-y-1 border-t border-zinc-700 pt-3 text-sm">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center px-3 py-2 rounded hover:bg-zinc-700
                   {{ request()->routeIs('dashboard') ? 'bg-zinc-700 text-white' : 'text-zinc-300' }}">
                    <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5" />
                    </svg>
                    Avaleht
                </a>

                <a href="{{ route('profile.show') }}"
                   class="flex items-center px-3 py-2 rounded hover:bg-zinc-700
                   {{ request()->routeIs('profile.show') ? 'bg-zinc-700 text-white' : 'text-zinc-300' }}">
                    <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 9.75a3 3 0 11-6 0 3 3 0 016 0z
                                 M19.5 19.5a7.5 7.5 0 00-15 0" />
                    </svg>
                    Profiil
                </a>
            </nav>

        </div>
    </aside>

    {{-- RIGHT CONTENT --}}
    <main class="flex-1 bg-zinc-800 overflow-y-auto px-6 py-6">
        <h1 class="text-xl font-medium mb-4">
            {{ $title ?? 'Avaleht' }}
        </h1>

        {{ $slot }}
    </main>

</div>

@livewireScripts
</body>
</html>
