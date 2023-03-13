<?php

declare(strict_types=1);

namespace Tests;

use PreemStudio\Jetpack\Tests\AbstractAnalysisTestCase;

final class AnalysisTest extends AbstractAnalysisTestCase
{
    public static function getPaths(): array
    {
        return [
            realpath(__DIR__.'/../src'),
            realpath(__DIR__),
        ];
    }
}
