<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsWhitelisted
{
    public function handle(Request $request, Closure $next): Response
    {
        $u = $request->user();

        // kui pole loginud, siis auth middleware tegeleb sellega
        if (!$u) {
            return redirect()->route('login');
        }

        // ✅ kui RP test on nõutud ja pole läbitud -> verification
        if ($u->requires_rp_test && !$u->rp_test_passed) {
            return redirect()->route('verification');
        }

        // ✅ Discord + Steam kohustuslikud
        if (empty($u->discord_id) || empty($u->steam_hex)) {
            return redirect()->route('verification');
        }

        // ✅ kõik korras
        return $next($request);
    }
}