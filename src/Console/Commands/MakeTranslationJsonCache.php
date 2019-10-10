<?php

namespace Krisell\LaravelTranslationJsonCache\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Translation\FileLoader;
use Illuminate\Support\Facades\Storage;
use Krisell\LaravelTranslationJsonCache\FastFileLoader;

class MakeTranslationJsonCache extends Command
{
    protected $signature = 'translation-json:cache';

    protected $description = 'Creates cached translation JSON-files, which are then automatically used.';

    public function handle()
    {
        $this->call('translation-json:clear');

        $this->getTranslationJsonFiles()->each(function ($file) {
            $locale = basename($file, '.json');
            $translations = app('translation.loader')->load($locale, '*', '*');
            $path = base_path("/bootstrap/cache/translation-{$locale}.php");
            File::put($path, '<?php return '.var_export($translations, true).';'.PHP_EOL);
        });

        $this->info("Translation JSON cached successfully!");
    }

    private function getTranslationJsonFiles() {
        return collect(File::files(base_path().'/resources/lang'))->map(function ($file) {
            return $file->getFilename();
        })->filter(function ($filename) {
            return preg_match('/.*.json/', $filename);
        });
    }
}
