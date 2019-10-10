<?php

use Krisell\LaravelTranslationJsonCache\Tests\TestCase;

class TranslationJsonCacheTest extends TestCase
{
    /** @test */
    function the_cache_file_is_used_when_it_exists()
    {
        file_put_contents(base_path().'/bootstrap/cache/translation-en.php', '<?php return ["Test" => "Testing"];');

        $this->assertEquals("Testing", __("Test"));
    }

    /** @test */
    function the_cache_file_is_not_used_when_it_does_not_exist()
    {
        $this->assertEquals("Test", __("Test"));
    }

    /** @test */
    function the_cached_file_takes_presendece_if_it_differs_from_the_json_file()
    {
        file_put_contents(base_path().'/bootstrap/cache/translation-en.php', '<?php return ["Test" => "Testing123"];');
        file_put_contents(base_path().'/resources/lang/en.json', '{"Test":"Testing"}');

        $this->assertEquals("Testing123", __("Test"));
    }
}
