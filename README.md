## Sharelov : URL Shortener

| develop  | master |
|---|---|
| [![StyleCI](https://styleci.io/repos/119410228/shield?style=plastic&branch=develop)](https://styleci.io/repos/119410228) [![CircleCI](https://circleci.com/gh/Sharelov/sharelov-shortener/tree/develop.svg?style=svg)](https://circleci.com/gh/Sharelov/sharelov-shortener/tree/develop)  | [![StyleCI](https://styleci.io/repos/119410228/shield?style=plastic&branch=master)](https://styleci.io/repos/119410228) [![CircleCI](https://circleci.com/gh/Sharelov/sharelov-shortener/tree/master.svg?style=svg)](https://circleci.com/gh/Sharelov/sharelov-shortener/tree/master) |

# Installation

Require the package with Composer:
```
composer require sharelov/sharelov-shortener
```

After that, add the ServiceProvider to the providers array in `config/app.php`
```php
Sharelov\Shortener\ShortenerServiceProvider::class,
```

You can optionally use the facade. If you decide to use it, add this to your aliases array in `config/app.php`:
```php
'Shortener'=>Sharelov\Shortener\Facades\Shortener::class,
```

Then, run `composer dump-autoload`.

Afterwards, run `php artisan vendor:publish` to get the migration and config files.

# Configuration

The config file has important configuration you may want to look at and customize before running the migrations. If you haven't looked at it yet, you can customize the table name in the config file, so there will be no need to fiddle with the migration yourself. Once you make sure the table name will not cause conflicts with your existing tables, run `php artisan migrate` to install the table we use.

There is also the posibility to configure any of the following things:
- Hash length. (Default = 5)
- Maximum attempts at generating a unique hash. (Default = 3)
- Usage of Soft Deletes with your short links model. (Default = false)

There is ample documentation for each option in the config file. Feel free to trim it down after having looked it over and setting it up.

# Usage

Use this route to decode a shortened URL, if the URL doesn't exist it will run `abort(404)` otherwise it will perform a redirect to the stored url asociated with that hash.
```php
Route::get('/sh/{hash}',[
    'as'=>'shortener.get',
    'uses'=>'\Sharelov\Shortener\Controllers\LinksController@translateHash'
]);
```

Use this route to shorten a URL, if the URL already exists on the database it will return the hash code otherwise it will create  a new URL|Hash tuple and it will return a json response with the hash and the url with the current domain indicating the status of the request.

The url receives the following query parameters:

Url to process by the shortener: `url=urltoshorten`

Expiration date for the link `expires_at=YYYY-MM-DD` (don't specify this in order to make the link not expire)


You can have an example of the requests on this postman collection:
[PostMan Shortener Collection](https://www.getpostman.com/collections/ec779d63f1fe3af3bc6d)

```php
Route::post('/sh',[
    'as'=>'shortener.store',
    'uses'=>'\Sharelov\Shortener\Controllers\LinksController@store'
]);
```
Succesfull json response
```json
{
    "success": "true",
    "hash": "D7ZR6",
    "url": "http://sharelovdev.dev/sh/D7ZR6"
}
```
Unsuccessfull json response
```json
{
    "success": "false",
    "hash": "",
    "url": ""
}
```

For using the facade don't forget to include it `use Shortener;` and then you can call the next methods:

Returns the hash for the url sended as a parameter and stores an object in the links table.
```php
Shortener::make($url)
```

Returns the url corresponding to a hash string in the database.
```php
Shortener::getUrlByHash($hash)
```

# License
This Laravel package is licensed with the [MIT License](https://choosealicense.com/licenses/mit/#).
