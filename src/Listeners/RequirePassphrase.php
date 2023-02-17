<?php

declare(strict_types=1);

namespace PreemStudio\Passwordless\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PreemStudio\Passphrase\EFF;
use PreemStudio\Passwordless\Enums\AuthSession;
use PreemStudio\Passwordless\Notifications\SendPassphrase;

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
