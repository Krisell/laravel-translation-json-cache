<?php

namespace Krisell\LaravelTranslationJsonCache\Tests;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Krisell\LaravelTranslationJsonCache\TranslationJsonCacheServiceProvider;
use Krisell\LaravelTranslationJsonCache\ClearJsonCacheCommandServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        app()->setLocale('en');
        if (file_exists(base_path() . '/resources/lang/en.json')) {
            unlink(base_path() . '/resources/lang/en.json');
        }

        if (file_exists(base_path() . '/resources/lang/fr.json')) {
            unlink(base_path() . '/resources/lang/fr.json');
        }

        $this->artisan("translation-json:clear");
    }

    protected function getFiles()
    {
        return collect(File::files(base_path('bootstrap/cache/')))->map(function ($file) {
            return $file->getFilename();
        })->filter(function ($filename) {
            return preg_match('/translation-.*.php/', $filename);
        });
    }

    protected function getPackageProviders($app)
    {
        return [
            TranslationJsonCacheServiceProvider::class,
            ClearJsonCacheCommandServiceProvider::class,
        ];
    }
}
