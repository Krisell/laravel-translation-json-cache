<?php

namespace Krisell\LaravelTranslationJsonCache;

use Illuminate\Support\Facades\File;
use Illuminate\Translation\FileLoader;

class FastFileLoader extends FileLoader {
    protected function loadJsonPaths($locale) {
        $path = storage_path("app/translation-cache-{$locale}.php");

        if (File::exists($path)) {
            return require $path;
        }

        return tap(parent::loadJsonPaths($locale), function ($translations) use ($path) {
            if (config('translation-json-cache.active') === true) {
                File::put($path, '<?php return '.var_export($translations, true).';'.PHP_EOL);
            }
        });
    }
}