<?php

namespace Krisell\LaravelTranslationJsonCache;

use Illuminate\Support\Facades\File;
use Illuminate\Translation\FileLoader;

class FastFileLoader extends FileLoader
{
    protected function loadJsonPaths($locale)
    {
        return File::exists($path = base_path("/bootstrap/cache/translation-{$locale}.php"))
            ? require $path
            : parent::loadJsonPaths($locale);
    }
}
