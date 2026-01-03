<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Verification;
use App\Http\Controllers\DiscordAuthController;
use App\Http\Controllers\SteamAuthController;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    // kui pole loginud → welcome
    if (!auth()->check()) {
        return view('welcome');
    }

    $u = auth()->user();

    // RP test (kui nõutud)
    $needsRp = $u->requires_rp_test && !$u->rp_test_passed;

    // Discord / Steam
    $needsConnections = empty($u->discord_id) || empty($u->steam_hex);

    if ($needsRp || $needsConnections) {
        return redirect()->route('verification');
    }

    return redirect()->route('dashboard');

})->name('home');


Route::get('/reeglid', function () {
    return view('legal', [
        'page' => 'rules',
        'title' => 'Eclipse RP — Serveri reeglid',
        'headline' => 'Reeglid',
        'updatedAt' => '01.01.2026',
    ]);
})->name('rules');


Route::get('/tingimused', function () {
    return view('legal', [
        'page' => 'tos',
        'title' => 'Eclipse RP — Teenustingimused',
        'headline' => 'Teenustingimused',
        'updatedAt' => '01.01.2026',
    ]);
})->name('tos');


/*
|--------------------------------------------------------------------------
| Dashboard (KÕIK PEAB OLEMA TEHTUD)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'whitelisted',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});


/*
|--------------------------------------------------------------------------
| Verification flow (ainult auth)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Discord
    Route::get('/auth/discord', [DiscordAuthController::class, 'redirect'])
        ->name('discord.redirect');

    Route::get('/auth/discord/callback', [DiscordAuthController::class, 'callback'])
        ->name('discord.callback');

    // Steam
    Route::get('/auth/steam', [SteamAuthController::class, 'redirect'])
        ->name('steam.redirect');

    Route::get('/auth/steam/callback', [SteamAuthController::class, 'callback'])
        ->name('steam.callback');

    // Verification UI
    Route::get('/verification', Verification::class)
        ->name('verification');

});
