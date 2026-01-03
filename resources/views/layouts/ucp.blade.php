@props([
    'title' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ? $title.' — Eclipse RP' : 'Eclipse RP UCP' }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-zinc-100 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-100 antialiased">
<div
    x-data="{ page: '{{ $attributes->get('page', 'dashboard') }}' }"
    class="min-h-screen"
>
    {{-- TOP HEADER --}}
    <header class="sticky top-0 z-40 border-b border-zinc-200 bg-white/80 backdrop-blur dark:border-white/10 dark:bg-zinc-950/70">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/ecrp.png') }}" alt="ECRP" class="h-8 w-auto">
                        <div class="leading-tight">
                            <div class="text-sm font-extrabold tracking-wide">Eclipse RP</div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">UCP</div>
                        </div>
                    </a>
                </div>

                {{-- MOBILE PAGE SWITCH --}}
                <div class="md:hidden flex-1">
                    <select
                        class="w-full rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 shadow-sm
                               dark:border-white/10 dark:bg-zinc-900 dark:text-zinc-100"
                        x-model="page"
                        @change="
                            if (page === 'dashboard') window.location='{{ route('dashboard') }}';
                            if (page === 'profile') window.location='{{ route('profile.show') }}';
                        "
                    >
                        <option value="dashboard">Avaleht</option>
                        <option value="profile">Profiil</option>
                    </select>
                </div>

                {{-- USER MENU --}}
                <div class="flex items-center gap-2">
                    <a
                        href="{{ route('verification') }}"
                        class="hidden sm:inline-flex items-center gap-2 rounded-lg border border-zinc-200 bg-white px-3 py-2 text-xs font-semibold text-zinc-800
                               hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-900 dark:text-zinc-100 dark:hover:bg-white/5"
                    >
                        Verifitseerimine
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8L11 17"/>
                        </svg>
                    </a>

                    <div class="relative" x-data="{ open: false }">
                        <button
                            type="button"
                            @click="open = !open"
                            class="inline-flex items-center gap-2 rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm font-semibold text-zinc-800 shadow-sm
                                   hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-900 dark:text-zinc-100 dark:hover:bg-white/5"
                        >
                            <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                            <svg class="h-4 w-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div
                            x-cloak
                            x-show="open"
                            @click.outside="open = false"
                            x-transition.opacity.duration.150
                            class="absolute right-0 mt-2 w-56 overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-lg
                                   dark:border-white/10 dark:bg-zinc-900"
                        >
                            <div class="px-4 py-3">
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">Sisselogitud</div>
                                <div class="text-sm font-semibold truncate">{{ auth()->user()->email }}</div>
                            </div>

                            <div class="border-t border-zinc-200 dark:border-white/10"></div>

                            <a
                                href="{{ route('profile.show') }}"
                                class="block px-4 py-2 text-sm hover:bg-zinc-50 dark:hover:bg-white/5"
                                @click="open = false"
                            >
                                Profiil
                            </a>

                            <a
                                href="{{ route('dashboard') }}"
                                class="block px-4 py-2 text-sm hover:bg-zinc-50 dark:hover:bg-white/5"
                                @click="open = false"
                            >
                                Avaleht
                            </a>

                            <div class="border-t border-zinc-200 dark:border-white/10"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-zinc-50 dark:text-red-400 dark:hover:bg-white/5"
                                >
                                    Logi välja
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    {{-- MAIN SHELL --}}
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="rounded-2xl overflow-hidden border border-zinc-200 bg-white shadow-sm dark:border-white/10 dark:bg-zinc-900">
            <div class="flex min-h-[calc(100vh-10rem)]">

                {{-- SIDEBAR (DESKTOP) --}}
                <aside class="hidden md:flex w-72 shrink-0 border-r border-zinc-200 bg-zinc-900 text-zinc-200 dark:border-white/10">
                    <div class="flex w-full flex-col">
                        <div class="px-5 pt-6 pb-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('images/ecrp.png') }}" class="h-10 w-auto" alt="ECRP">
                                <div class="leading-tight">
                                    <div class="text-white font-extrabold text-xl">Eclipse RP</div>
                                    <div class="text-xs text-zinc-400">UCP Avaleht</div>
                                </div>
                            </div>

                            <div class="mt-4 rounded-xl border border-white/10 bg-black/30 px-3 py-2">
                                <div class="text-xs text-zinc-400">Konto</div>
                                <div class="text-sm font-semibold truncate text-white">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-zinc-400 truncate">{{ auth()->user()->email }}</div>
                            </div>
                        </div>

                        <nav class="px-3 pb-6 space-y-1 border-t border-white/10 pt-4">
                            <a
                                href="{{ route('dashboard') }}"
                                class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold transition
                                {{ request()->routeIs('dashboard') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-800 hover:text-white' }}"
                            >
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h8V3H3v10zm10 8h8V11h-8v10zM3 21h8v-6H3v6zm10-18h8v6h-8V3z"/>
                                </svg>
                                Avaleht
                            </a>

                            <a
                                href="{{ route('profile.show') }}"
                                class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold transition
                                {{ request()->routeIs('profile.show') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-800 hover:text-white' }}"
                            >
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"/>
                                </svg>
                                Profiil
                            </a>

                            <a
                                href="{{ route('verification') }}"
                                class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold transition
                                {{ request()->routeIs('verification') ? 'bg-zinc-700 text-white' : 'text-zinc-300 hover:bg-zinc-800 hover:text-white' }}"
                            >
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l7.5 4.5v6c0 5.25-3.75 8.25-7.5 9.5-3.75-1.25-7.5-4.25-7.5-9.5v-6L12 3z"/>
                                </svg>
                                Verifitseerimine
                            </a>
                        </nav>

                        <div class="mt-auto px-5 pb-5 text-xs text-zinc-400">
                            © {{ date('Y') }} Eclipse RP
                        </div>
                    </div>
                </aside>

                {{-- CONTENT AREA --}}
                <main class="flex-1 bg-zinc-100 dark:bg-zinc-950">
                    <div class="p-5 sm:p-6">
                        {{ $slot }}
                    </div>
                </main>

            </div>
        </div>
    </div>
</div>
</body>
</html>
