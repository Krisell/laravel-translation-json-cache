<?php

namespace Krisell\LaravelTranslationJsonCache\Tests;

use Illuminate\Support\Facades\Storage;
use Krisell\LaravelTranslationJsonCache\TranslationJsonCacheServiceProvider;
use Krisell\LaravelTranslationJsonCache\ClearJsonCacheCommandServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        app()->setLocale('en');
        $jsonPath = base_path() . '/resources/lang/en.json';

        if (file_exists($jsonPath)) {
            unlink($jsonPath);
        }

        Storage::delete('translation-cache-en.php');
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
