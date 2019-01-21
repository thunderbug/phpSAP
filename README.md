# Library to run SAP read table requests via PHP #

## Requirements ##
I'm using this library to be able to run these commands: https://github.com/gkralik/php7-sapnwrfc

## Installation & Usage ##

Configure the SAPconfig.php file, and start using it by calling 

```php
require_once("SAP.php");
$SAP = new \SAP\SAP();
$SAP->RFC_READ_TABLE(XX, XX, XX, 100);
```

Have fun!
