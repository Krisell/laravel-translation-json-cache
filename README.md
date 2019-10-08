# Laravel Translation Json Cache

When using the `.json`option for translations, the json-file is read and parsed for every request. This package caches the parsed data as a php-file after the first request, making all subsequent reqeusts faster since no parsing has to be done and the opcache can be used. The actual performance boost depends on the size of the translation file and the filesystem. I'm hoping to add some reference measurements here soon.

## Installation
```bash
composer require krisell/laravel-translation-json-cache
```

The package is auto-registered.

## Usage
The functionality is opt-in, since we only want to use this in production and not during local development.
```bash
TRANSLATION_JSON_CACHE_ENABLED=true
```

If your json-files change, you need to clear the cached files for the changes to take effect, if this package is enabled. To simplify this, the package provides an artisan-command:

```
translation-json-cache:clear
```

Run this during deployment, unless you have a setup where the whole filesystem is reset (e.g. using Docker), in which case you should never have to run this command.

The cached files are stored in the `storage/app` directory and are named `translation-cache-{$locale}.php`. The command simply deletes these files, and you may also safely delete them manually.