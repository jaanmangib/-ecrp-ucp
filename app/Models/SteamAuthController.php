<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SteamAuthController extends Controller
{
    public function redirect()
    {
        // Steam OpenID redirect
        return Socialite::driver('steam')->redirect();
    }

    public function callback(Request $request)
    {
        $user = Auth::user();

        // Kui user pole logged in, suuna loginisse (või tee oma flow)
        if (!$user) {
            return redirect()->route('login');
        }

        $steamUser = Socialite::driver('steam')->user();

        // Steam provider annab ID (enamasti stringina) -> see on steamid64
        $steamId64 = (string) ($steamUser->getId() ?? '');

        if ($steamId64 === '' || !ctype_digit($steamId64)) {
            return redirect()
                ->route('verification')
                ->with('error', 'Steam ühendamine ebaõnnestus (steamid puudu).');
        }

        // FiveM "steam:" HEX (steamid64 -> hex)
        // PHP 64-bit int kannatab steamid64 ilusti välja.
        $steamHex = 'steam:' . strtolower(dechex((int) $steamId64));

        $user->forceFill([
            'steam_id64' => $steamId64,
            'steam_hex' => $steamHex,
            'steam_connected_at' => now(),
        ])->save();

        return redirect()
            ->route('verification')
            ->with('success', 'Steam on ühendatud: ' . $steamHex);
    }
}
