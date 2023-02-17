<?php

declare(strict_types=1);

namespace Tests;

use Laravel\Fortify\FortifyServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use PreemStudio\Passwordless\ServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            FortifyServiceProvider::class,
            ServiceProvider::class,
        ];
    }
}
