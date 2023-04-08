<?php

declare(strict_types=1);

namespace Tests;

use PreemStudio\Jetpack\TestBench\AbstractPackageTestCase;

/**
 * @internal
 */
abstract class TestCase extends AbstractPackageTestCase
{
    protected function getRequiredServiceProviders(): array
    {
        return [
            \Laravel\Fortify\FortifyServiceProvider::class,
        ];
    }

    protected function getServiceProviderClass(): string
    {
        return \PreemStudio\Passwordless\ServiceProvider::class;
    }
}
