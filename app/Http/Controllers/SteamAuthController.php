<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SteamAuthController extends Controller
{
    private const STEAM_OPENID_URL = 'https://steamcommunity.com/openid/login';

    public function redirect(Request $request)
    {
        // Steam OpenID return_to peab olema sama domeeniga kui realm.
        // Pane .env APP_URL=http://127.0.0.1:8000
        $returnTo = route('steam.callback');
        $realm    = rtrim(config('app.url'), '/');

        $params = [
            'openid.ns'         => 'http://specs.openid.net/auth/2.0',
            'openid.mode'       => 'checkid_setup',
            'openid.return_to'  => $returnTo,
            'openid.realm'      => $realm,
            'openid.identity'   => 'http://specs.openid.net/auth/2.0/identifier_select',
            'openid.claimed_id' => 'http://specs.openid.net/auth/2.0/identifier_select',
        ];

        return redirect(self::STEAM_OPENID_URL . '?' . http_build_query($params));
    }

    public function callback(Request $request)
    {
        // Kui kasutaja vajutas Cancel vms
        if ($request->get('openid_mode') === 'cancel') {
            return redirect()->route('verification')->with('error', 'Steam ühendamine katkestati.');
        }

        // Steam OpenID vastus peab sisaldama neid (min)
        if (!$request->filled('openid_claimed_id') || !$request->filled('openid_sig') || !$request->filled('openid_signed')) {
            return redirect()->route('verification')->with('error', 'Steam vastus on vigane (puuduvad OpenID väljad).');
        }

        // Kontrollime Steamiga, et OpenID vastus on päriselt valideeritud
        $payload = $this->buildCheckAuthenticationPayload($request);

        $resp = Http::asForm()->post(self::STEAM_OPENID_URL, $payload);

        if (!$resp->ok() || !str_contains((string)$resp->body(), 'is_valid:true')) {
            return redirect()->route('verification')->with('error', 'Steam ühendamine ebaõnnestus (OpenID verify).');
        }

        // Võta SteamID64 claimed_id URL-ist
        $claimedId = (string) $request->get('openid_claimed_id');
        $steamId64 = $this->extractSteamId64($claimedId);

        if (!$steamId64) {
            return redirect()->route('verification')->with('error', 'SteamID64 ei leitud (claimed_id).');
        }

        $user = Auth::user();

        // FiveM "steam:" hex
        $steamHex = 'steam:' . strtolower($this->decToHexString($steamId64));

        $user->forceFill([
            'steam_id64' => $steamId64,
            'steam_hex' => $steamHex,
            'steam_connected_at' => now(),
        ])->save();

        // Kui kõik tehtud, lase edasi dashboardi (või jää verificationile)
        // (Sinu verification lehel on niikuinii nupp “Edasi Dashboardi”.)
        return redirect()->route('verification')->with('success', 'Steam ühendatud ✅');
    }

    private function buildCheckAuthenticationPayload(Request $request): array
    {
        // Me peame saatma tagasi kõik openid_* väljad, aga mode peab olema check_authentication
        $all = [];
        foreach ($request->query() as $k => $v) {
            if (str_starts_with($k, 'openid_')) {
                // openid_assoc_handle -> openid.assoc_handle
                $all[str_replace('openid_', 'openid.', $k)] = $v;
            }
        }

        $all['openid.mode'] = 'check_authentication';

        return $all;
    }

    private function extractSteamId64(string $claimedId): ?string
    {
        // claimed_id näeb välja:
        // https://steamcommunity.com/openid/id/7656119xxxxxxxxxx
        if (preg_match('~^https?://steamcommunity\.com/openid/id/(\d+)$~', $claimedId, $m)) {
            return $m[1];
        }
        return null;
    }

    private function decToHexString(string $dec): string
    {
        // Kõige kindlam: GMP -> BCMath -> fallback int (töötab praktikas SteamID64-ga)
        if (function_exists('gmp_init')) {
            return gmp_strval(gmp_init($dec, 10), 16);
        }

        if (function_exists('bcdiv')) {
            // BCMath conversion
            $hex = '';
            $num = $dec;

            while (bccomp($num, '0') > 0) {
                $rem = bcmod($num, '16'); // 0..15
                $hex = dechex((int)$rem) . $hex;
                $num = bcdiv($num, '16', 0);
            }

            return $hex === '' ? '0' : $hex;
        }

        // Fallback (SteamID64 mahub 64-bit int sisse)
        return dechex((int)$dec);
    }
}
