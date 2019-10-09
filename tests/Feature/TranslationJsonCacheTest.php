<?php

use Krisell\LaravelTranslationJsonCache\Tests\TestCase;

class TranslationJsonCacheTest extends TestCase
{
    /** @test */
    function the_cache_file_is_created_when_the_env_variable_is_true()
    {
        config(['translation-json-cache.active' => true]);

        __("Test");

        $this->assertTrue(Storage::exists('translation-cache-en.php'));
    }

    /** @test */
    function the_cache_file_is_not_created_when_the_env_variable_is_false()
    {
        config(['translation-json-cache.active' => false]);

        __("Test");

        $this->assertFalse(Storage::exists('translation-cache-en.php'));
    }

    /** @test */
    function the_cache_file_is_not_created_when_the_env_variable_is_missing()
    {
        config(['translation-json-cache.active' => null]);

        __("Test");

        $this->assertFalse(Storage::exists('translation-cache-en.php'));
    }

    /** @test */
    function the_cache_file_is_used_when_the_env_variable_is_set_to_true()
    {
        Storage::put('translation-cache-en.php', '<?php return ["Test" => "Testing"];');
        config(['translation-json-cache.active' => true]);

        $this->assertEquals("Testing", __("Test"));
    }

    /** @test */
    function the_cache_file_is_not_used_when_the_env_variable_is_set_to_false()
    {
        Storage::put('translation-cache-en.php', '<?php return ["Test" => "Testing"];');
        config(['translation-json-cache.active' => false]);

        $this->assertEquals("Test", __("Test"));
    }

    /** @test */
    function the_cache_file_is_not_used_when_the_env_variable_is_missing()
    {
        Storage::put('translation-cache-en.php', '<?php return ["Test" => "Testing"];');
        config(['translation-json-cache.active' => null]);

        $this->assertEquals("Test", __("Test"));
    }

    /** @test */
    function the_data_in_the_cached_file_corresponds_to_the_json_file()
    {
        file_put_contents(base_path() . '/resources/lang/en.json', '{"Test":"Testing"}');
        config(['translation-json-cache.active' => true]);

        $this->assertEquals("Testing", __("Test"));

        $data = require storage_path() . '/app/translation-cache-en.php';
        $this->assertEquals('Testing', $data['Test']);
    }

    /** @test */
    function the_cached_file_takes_presendece_if_it_differs_from_the_json_file()
    {
        file_put_contents(base_path() . '/resources/lang/en.json', '{"Test":"Testing"}');
        file_put_contents(storage_path() . '/app/translation-cache-en.php', '<?php return ["Test" => "Testing2"];');
        config(['translation-json-cache.active' => true]);

        $this->assertEquals("Testing2", __("Test"));
    }
}
