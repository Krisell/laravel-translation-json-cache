<?php

use Krisell\LaravelTranslationJsonCache\Tests\TestCase;

class ClearJsonCacheCommandTest extends TestCase
{
    /** @test */
    public function the_artisan_commands_prints_output_after_being_done()
    {
        $this->artisan("translation-json:clear")
            ->expectsOutput("Translation JSON cache cleared!");
    }

    /** @test */
    public function the_artisan_commands_clear_cache_files()
    {
        $this->assertCount(0, $this->getFiles());

        File::put(base_path('bootstrap/cache/translation-en.php'), 'a');
        File::put(base_path('bootstrap/cache/translation-sv.php'), 'b');
        File::put(base_path('bootstrap/cache/translation-fr.php'), 'c');

        $this->assertCount(3, $this->getFiles());

        $this->artisan("translation-json:clear");

        $this->assertCount(0, $this->getFiles());
    }
}
