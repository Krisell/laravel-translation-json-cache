<?php

namespace Krisell\LaravelTranslationJsonCache\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ClearTranslationJsonCache extends Command
{
    protected $signature = 'translation-json:clear';

    protected $description = 'Deletes cached translation JSON-files,
        letting the application fallback to the JSON files.';

    public function handle()
    {
        $files = collect(File::files(base_path("bootstrap/cache/")))->map(function ($file) {
            return $file->getFilename();
        })->filter(function ($filename) {
            return preg_match('/translation-.*\.php/', $filename);
        })->each(function ($cacheFile) {
            File::delete(base_path("bootstrap/cache/{$cacheFile}"));
        });

        $this->info("Translation JSON cache cleared!");
    }
}
