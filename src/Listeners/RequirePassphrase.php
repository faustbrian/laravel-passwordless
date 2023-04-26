<?php

declare(strict_types=1);

namespace BombenProdukt\Passwordless\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use BombenProdukt\Passphrase\EFF;
use BombenProdukt\Passwordless\Enums\AuthSession;
use BombenProdukt\Passwordless\Notifications\SendPassphrase;

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
