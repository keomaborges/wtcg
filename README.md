# WTCG
You probably know what this is about. This program was made to run by CLI only.

By Keoma Borges.

## Requirements
* PHP 7.4.*
* [Composer](https://getcomposer.org/)

## Instructions
1. Clone this repo.
2. `cd wtcg` or to the path where you cloned/downloaded it

If you OS supports `make`:
* `make install`
* `make run`

Otherwise:
* `composer install`
* `php run.php`


## Tests

If you OS supports `make`:
* `make test`

Otherwise:
* `vendor/bin/phpunit tests/RunTest.php`
