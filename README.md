## Installation

```sh
composer install
```

## External Packages

`soapbox/laravel-formatter` - to convert data from xml to array and array to csv

`box/spout` - to read from the final csv for testing purposes

`guzzlehttp/guzzle` - for the http request to the external client renewal service

## Launch Command

```sh
php artisan clientRenewals:generate {--input=} {--filename=}
```

### Options

`--input=json` (default): Call the service at https://jsonplaceholder.typicode.com/users

`--input=xml` : Read in 'example_client_renewals.xml' from the root directory

### Filename

`--filename={desiredFileName}` (default - clientRenewals): 'desiredFileNameDDMMYYYY.csv' will be outputted to the root directory

## Run Tests

```sh
vendor/bin/phpunit
```