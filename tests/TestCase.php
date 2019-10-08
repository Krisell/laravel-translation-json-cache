<?php

namespace Krisell\LaravelTranslationJsonCache\Tests;

use Krisell\LaravelTranslationJsonCache\TranslationJsonCacheServiceProvider;


class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            TranslationJsonCacheServiceProvider::class,
            ClearJsonCacheCommandServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
    }
}
