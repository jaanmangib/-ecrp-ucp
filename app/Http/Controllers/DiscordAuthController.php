<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DiscordAuthController extends Controller
{
    public function redirect()
    {
        $clientId = config('services.discord.client_id');
        $redirectUri = config('services.discord.redirect');
        $scopes = 'identify guilds.join';

        $url = 'https://discord.com/api/oauth2/authorize?' . http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => $scopes,
            'prompt' => 'consent',
        ]);

        return redirect()->away($url);
    }

    public function callback(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        $user = Auth::user();

        // 1) Vaheta code access tokeniks
        $tokenRes = Http::asForm()->post('https://discord.com/api/oauth2/token', [
            'client_id' => config('services.discord.client_id'),
            'client_secret' => config('services.discord.client_secret'),
            'grant_type' => 'authorization_code',
            'code' => $request->string('code'),
            'redirect_uri' => config('services.discord.redirect'),
        ]);

        if (!$tokenRes->ok()) {
            return redirect()
                ->route('verification')
                ->with('error', 'Discordi autentimine ebaõnnestus (token).');
        }

        $accessToken = $tokenRes->json('access_token');

        // 2) Küsi kasutaja info (identify scope)
        $meRes = Http::withToken($accessToken)->get('https://discord.com/api/users/@me');

        if (!$meRes->ok()) {
            return redirect()
                ->route('verification')
                ->with('error', 'Discordi autentimine ebaõnnestus (user info).');
        }

        $discordId = (string) $meRes->json('id');
        $username = (string) $meRes->json('username');
        $discriminator = (string) ($meRes->json('discriminator') ?? '0');
        $globalName = (string) ($meRes->json('global_name') ?? '');
        $avatar = (string) ($meRes->json('avatar') ?? '');

        $prettyName = $globalName !== '' ? $globalName : ($discriminator !== '0'
            ? "{$username}#{$discriminator}"
            : $username);

        $avatarUrl = null;
        if ($avatar !== '') {
            $ext = str_starts_with($avatar, 'a_') ? 'gif' : 'png';
            $avatarUrl = "https://cdn.discordapp.com/avatars/{$discordId}/{$avatar}.{$ext}?size=256";
        }

        // 3) Salvesta DB-sse
        $user->forceFill([
            'discord_id' => $discordId,
            'discord_username' => $prettyName,
            'discord_avatar' => $avatarUrl,
            'discord_connected_at' => now(),
        ])->save();

        // 4) Lisa Discord serverisse + anna role (botiga)
        $guildId = (string) config('services.discord.guild_id');
        $whitelistRoleId = (string) config('services.discord.whitelisted_role_id');
        $botToken = (string) config('services.discord.bot_token');

        if ($guildId && $botToken) {

            // 4.1) PUT /guilds/{guild.id}/members/{user.id}
            // NB: see endpoint nõuab Bot tokenit ja body-s access_token (user oauth)
            $joinRes = Http::withHeaders([
                'Authorization' => 'Bot ' . $botToken,
                'Content-Type' => 'application/json',
            ])->put("https://discord.com/api/guilds/{$guildId}/members/{$discordId}", [
                'access_token' => $accessToken,
            ]);

            // Kui liitumine ebaõnnestub, ära kogu flow'd maha tapa - lihtsalt logi/teavita
            if (!$joinRes->successful()) {
                // optional: \Log::warning('Discord guild join failed', ['body' => $joinRes->body()]);
            }

            // 4.2) Anna Whitelisted roll (kui olemas)
            if ($whitelistRoleId) {
                $roleRes = Http::withHeaders([
                    'Authorization' => 'Bot ' . $botToken,
                ])->put("https://discord.com/api/guilds/{$guildId}/members/{$discordId}/roles/{$whitelistRoleId}");

                if (!$roleRes->successful()) {
                    // optional: \Log::warning('Discord role add failed', ['body' => $roleRes->body()]);
                }
            }
        }

        return redirect()
            ->route('verification')
            ->with('success', 'Discord ühendatud! Sind lisati serverisse ja anti whitelisted roll.');
    }
}
