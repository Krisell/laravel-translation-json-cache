# Laravel Translation Json Cache

When using the `.json` option for translations, the json-file is read and parsed for every request. This package provides an artisan command to cache the parsed data as a php-file, pretty much the same was as routes and configs can be cached. This gives a performance boost since no JSON-parsing has to be done and the opcache can be used. The actual performance boost depends on the size of the translation file and the disk speed, see below.

## Installation
```bash
composer require krisell/laravel-translation-json-cache
```

The package is auto-registered.

## Usage
To cache all translation JSON-files (in resources/lang), run the following artisan command:
```bash
php artisan translation-json:cache
```

If your json-files change, you need to run the command again for the changes to take effect.

You may also clear the cached files using the following command

```
php artisan translation-json:clear
```

Run `translation-json:cache` during deployment in the same way you run `route:cache` and `config:cache`.

The cached files are stored in the `bootstrap/cache` directory and are named `translation-{$locale}.php`.

## Performance boost
On a Macbook Pro 2018 (2.6 GHz i7), using Laravel Valet, and having a JSON translation file of 1500 strings (real strings of varying length), the first call to `__("A")` during a request takes about `1.2 ms`. Enabling this package and the same call takes `0.08 ms`, i.e. the actual performance boost is in the order of `1 ms`, which is substantial considering that a simple full request could be as fast as `10 ms`.

I have been using this solution in production for a while (1500 strings for each language) and I have to say the performance boost is not really noticable there (comparing CPU graphs, which of course depends on a lot of other changes as well). The difference may be smaller since our server setup uses docker and an all in-memory disk. Please feel free to contribute with additional measurements under other circumstances or with other sizes of the JSON files.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Future work
I realize the JSON-option may not be the preferred one, and that most people already use php-files for storing their translation data hierachically. In that case, a similar approach could still possibly save time on parsing and traversal, but this is outside the scope of this package. Feel free to investigate this idéa further in a new package!
