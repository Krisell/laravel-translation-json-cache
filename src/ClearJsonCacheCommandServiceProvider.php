<?php

namespace Krisell\LaravelTranslationJsonCache;

use Illuminate\Support\ServiceProvider;
use Krisell\LaravelTranslationJsonCache\Console\Commands\MakeTranslationJsonCache;
use Krisell\LaravelTranslationJsonCache\Console\Commands\ClearTranslationJsonCache;

class ClearJsonCacheCommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearTranslationJsonCache::class,
                MakeTranslationJsonCache::class,
            ]);
        }
    }
}
