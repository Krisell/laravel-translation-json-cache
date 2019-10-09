<?php

use Krisell\LaravelTranslationJsonCache\Tests\TestCase;

class ClearJsonCacheCommandTest extends TestCase
{
    /** @test */
    public function the_artisan_commands_prints_output_after_being_done()
    {
        $this->artisan("translation-json-cache:clear")
            ->expectsOutput("Translation JSON cache files cleared.");
    }

    /** @test */
    public function the_artisan_commands_clear_cache_files()
    {
        Storage::put('translation-cache-en.php', 'a');
        Storage::put('translation-cache-sv.php', 'b');
        Storage::put('translation-cache-fr.php', 'c');

        $this->assertCount(3, collect(Storage::files())->filter(function ($filename) {
            return preg_match('/.*-cache-.*/', $filename);
        }));

        $this->artisan("translation-json-cache:clear");

        $this->assertCount(0, collect(Storage::files())->filter(function ($filename) {
            return preg_match('/.*-cache-.*/', $filename);
        }));
    }
}
