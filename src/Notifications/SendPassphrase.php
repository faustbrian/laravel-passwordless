<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Passwordless\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class SendPassphrase extends Notification
{
    use Queueable;

    public function __construct(
        public string $passphrase,
    ) {}

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail()
    {
        return (new MailMessage())
            ->subject('Your login passphrase for '.config('app.name'))
            ->line('Here is your login passphrase. It will expire after 15 minutes.')
            ->line($this->passphrase)
            ->line('Thank you for using our application!');
    }
}
