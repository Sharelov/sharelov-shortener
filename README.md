## Sharelov : URL Shortener

[
![StyleCI](https://styleci.io/repos/119410228/shield?branch=develop)
](https://styleci.io/repos/119410228)

# Installation

Simply require the package with Composer:

```
composer require sharelov/sharelov-shortener
```
After updating composer, add the ServiceProvider to the providers array in `config/app.php`

```php
Sharelov\Shortener\ShortenerServiceProvider::class,
```

You can use the facade for shorter code. Add this to your aliases:

```php
'Shortener'=>Sharelov\Shortener\Facades\Shortener::class,
```

Then, run `composer dump-autoload`. 

Afterwards, run `php artisan vendor:publish` to get the migration and config files.

Check the config file to look for the table name. You can customize the table name in the config file, so there will be no need to fiddle with the migration yourself. Once you make sure the table name will not cause conflicts with your existing tables, run `php artisan migrate` to install the table we use.

# Usage

Use this route to decode a shortened URL, if the URL doesn't exist it will run `abort(404)` otherwise it will perform a redirect to the stored url asociated with that hash.
```php
Route::get('/sh/{hash}',[
    'as'=>'shortener.get',
    'uses'=>'\Sharelov\Shortener\Controllers\LinksController@translateHash'
]);
```

Use this route to shorten a URL, if the URL already exists on the database it will return the hash code otherwise it will create  a new URL|Hash tuple and it will return a json response with the hash and the url with the current domain indicating the status of the request.

The url recive the next as query parameters:

Url to process by the shortener:

    `url=urltoshorten`

Expiration date for the link (don't specify this in order to make the link not expire)

    `expires_at=Y-m-d`

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

For using the facade don't forguet to include it `use Shortener;` and then you can call the next methods:

Returns the hash for the url sended as a parameter and stores an object in the links table.
```php
Shortener::make($url)
```

Returns the url corresponding to a hash string in the database.
```php
Shortener::getUrlByHash($hash)
```

# Configuration

After you inovque `vendor:publish` a file by the name shortener.php will appear on the config folder, you can then specify there the domain name and the url to build the shortened urls. You could use these same configuration file for building the entry point for retrieving the urls.

```php
    'domain' =>'http://localhost:8000',
    'path'=>'sh',
```

# License
This Laravel package is licensed with the [MIT License](https://choosealicense.com/licenses/mit/#).