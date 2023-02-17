<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

final class User extends Model
{
    use Notifiable;
}
