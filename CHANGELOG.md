## 5.0
- Add support for laravel 6.x

## 4.0
- Add support for laravel 5.8

## 3.0.4
- Loosen hard requirement on `laravel/framework:5.4.*`

## 3.0.2, 3.0.3
- Several tweaks & bugfixes

## 3.0.1
- Making the url table column a mediumText column so urls fit when they have too many characters.
- Updated model to make sure it reads the custom table name from the config properly.
- Tests updated to check softDeletes properly.
- General bug squashing.

## 3.0.0
- SoftDeletes option.
- Configurable hash length.
- Configurable maximum attempts at generating a unique hash.

## 2.0.0
- Major bug fixes.

## 0.1.5
- Added tests.
- Better database migration handling.
- Added this changelog file to track the _juicy new features_ we add on each release from now on.