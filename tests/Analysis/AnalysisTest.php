<?php

declare(strict_types=1);

namespace PreemStudio\Passphrase\Tests\Analysis;

use GrahamCampbell\Analyzer\AnalysisTrait;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
final class AnalysisTest extends TestCase
{
    use AnalysisTrait;

    public static function getPaths(): array
    {
        return [
            realpath(__DIR__.'/../../src'),
            realpath(__DIR__),
        ];
    }
}
