<?php

use Illuminate\Support\Facades\File;
use Krisell\LaravelTranslationJsonCache\Tests\TestCase;

class MakeJsonCacheCommandTest extends TestCase
{
    /** @test */
    function no_cache_files_are_created_if_no_json_files_exist()
    {
        $this->artisan('translation-json:cache');

        $this->assertCount(0, $this->getFiles());
    }

    /** @test */
    function a_cache_file_is_created_when_running_the_cache_command()
    {
        file_put_contents(base_path().'/resources/lang/en.json', '{"Test":"Testing"}');

        $this->assertFalse(File::exists(base_path('/bootstrap/cache/translation-en.php')));
        $this->assertCount(0, $this->getFiles());

        $this->artisan('translation-json:cache');

        $this->assertTrue(File::exists(base_path('/bootstrap/cache/translation-en.php')));
        $this->assertCount(1, $this->getFiles());
    }

    /** @test */
    function one_cache_file_is_created_for_each_language()
    {
        file_put_contents(base_path().'/resources/lang/en.json', '{"Test":"Testing"}');
        file_put_contents(base_path().'/resources/lang/fr.json', '{"Test":"Testing"}');

        $this->artisan('translation-json:cache');

        $this->assertCount(2, $this->getFiles());
    }

    /** @test */
    function the_data_in_the_cached_file_corresponds_to_the_json_file ()
    {
        file_put_contents(base_path().'/resources/lang/en.json', '{"Test":"Testing123"}');

        $this->artisan('translation-json:cache');

        $data = require base_path().'/bootstrap/cache/translation-en.php';
        $this->assertEquals('Testing123', $data['Test']);
    }
}
