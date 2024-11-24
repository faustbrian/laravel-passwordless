<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Passwordless\Http\Middleware;

use BaseCodeOy\Passwordless\Enums\AuthSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class PassphraseGuard
{
    public function handle(Request $request, \Closure $next)
    {
        $passphrase = $request->session()->get(AuthSession::PASSPHRASE, null);

        if (null === $passphrase) {
            return $next($request);
        }

        if ($request->session()->get(AuthSession::PASSPHRASE_EXPIRATION) < Carbon::now()->timestamp) {
            $request->session()->forget(AuthSession::PASSPHRASE);
            $request->session()->forget(AuthSession::PASSPHRASE_EXPIRATION);

            Auth::logout();

            return redirect()->route('home');
        }

        if ($request->route()->named('login.*')) {
            return $next($request);
        }

        return redirect()->route('login.passwordless');
    }
}
