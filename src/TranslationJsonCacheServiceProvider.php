<?php

namespace Krisell\LaravelTranslationJsonCache;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Krisell\LaravelTranslationJsonCache\FastFileLoader;

class TranslationJsonCacheServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->extend('translation.loader', function ($translation, $app) {
            return new FastFileLoader($app['files'], $app['path.lang']);
        });
    }

    public function provides()
    {
        return ['translation.loader'];
    }
}
