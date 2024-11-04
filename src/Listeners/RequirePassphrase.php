<?php

declare(strict_types=1);

namespace BaseCodeOy\Passwordless\Listeners;

use BaseCodeOy\Passphrase\EFF;
use BaseCodeOy\Passwordless\Enums\AuthSession;
use BaseCodeOy\Passwordless\Notifications\SendPassphrase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

final class RequirePassphrase
{
    public function handle($event): void
    {
        if (Auth::viaRemember()) {
            return;
        }

        $passphrase = EFF::useFiveDiceList()->generate(5);

        Session::put(AuthSession::PASSPHRASE, $passphrase);
        Session::put(AuthSession::PASSPHRASE_EXPIRATION, now()->addMinutes(15)->timestamp);

        $event->user->notify(new SendPassphrase($passphrase));
    }
}
