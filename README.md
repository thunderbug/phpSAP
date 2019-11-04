# Library to run SAP read table requests via PHP #

A simple library to run commands via RFC in a easy way without the hassle and lack of information on which command is beeing used for what.

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


### PRODUCTION_ORDER_READ(int $order) ###

Get alot of information of a production order like its components, header information more info see https://www.sapdatasheet.org/abap/func/bapi_procord_get_detail.html.

```php
$order = $SAP->PRODUCTION_ORDER_READ(1000);
```

### HU_PRINT(string $handlingunit, string $output) ###

Print a Handling United on a selected device.

```php
$order = $SAP->HU_PRINT("104115021414613866", "DEVICE0000");
```