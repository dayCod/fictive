<?php

declare(strict_types=1);

namespace Daycode\Fictive\Tests;

use Daycode\Fictive\FictiveServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Set up the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Get the package providers.
     */
    protected function getPackageProviders($app): array
    {
        return [
            FictiveServiceProvider::class,
        ];
    }

    /**
     * Get the package aliases.
     */
    protected function getPackageAliases($app): array
    {
        return [
            'Fictive' => \Daycode\Fictive\Fictive::class,
        ];
    }
}
