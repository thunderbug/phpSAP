# Library to run SAP read table requests via PHP #

## Requirements ##
I'm using this library to be able to run these commands: https://github.com/gkralik/php7-sapnwrfc

## Installation ##

Installation via composer:

```bash 
composer require thunderbug/php-sap-interface
```

```php
require_once("vendor/autoload.php");
$SAP = new \SAP\SAP($host, $sysnr, $client, $user, $password, $debug);
```

## Usage ##

### RFC_READ_TABLE(string $table, array $fields, string $options, int $rows) ###

Read a table in SAP for example the [AFKO](https://www.sapdatasheet.org/abap/tabl/afko.html) table.
This returns a array with the table information and the results of the query.

```php
$data = $SAP->RFC_READ_TABLE("AFKO", array("MANDT", "AUFNR", "GLTRS", "PLNBEZ"), "MANDT EQ 100", 100);
```


### PRODUCTION_ORDER_READ(int $order, array $object) ###

