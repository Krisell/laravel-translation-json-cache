<?php

namespace Krisell\LaravelTranslationJsonCache\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearTranslationJsonCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translation-json-cache:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes cached translation JSON-files, allowing them to be regenereted automatically on the next request.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = collect(Storage::files())->filter(function ($filename) {
            return preg_match('/.*-cache-.*/', $filename);
        })->each(function ($cacheFile) {
            Storage::delete($cacheFile);
        });

        $this->info("Translation JSON cache files cleared.");
    }
}
