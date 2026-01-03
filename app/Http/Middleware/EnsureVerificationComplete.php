<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureVerificationComplete
{
    public function handle(Request $request, Closure $next)
    {
        $u = Auth::user();
        if (!$u) return redirect()->route('login');

        $rpOk = $u->requires_rp_test ? (bool) $u->rp_test_passed : true;
        $discordOk = !empty($u->discord_id);
        $steamOk = !empty($u->steam_id64) || !empty($u->steam_hex);

        if (!($rpOk && $discordOk && $steamOk)) {
            return redirect()->route('verification');
        }

        return $next($request);
    }
}
