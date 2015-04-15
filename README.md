[![Latest Stable Version](https://poser.pugx.org/jlaso/ovh-domain-api/v/stable.png)](https://packagist.org/packages/jlaso/ovh-domain-api)
[![Total Downloads](https://poser.pugx.org/jlaso/ovh-domain-api/downloads.png)](https://packagist.org/packages/jlaso/ovh-domain-api)

========
Overview
========

This module permits comunication with ovh.com API

Installation
------------
Checkout a copy of the code::

    // in composer.json
    "require": {
        // ...
        "jlaso/ovh-domain-api": "*"
        // ...
    }
    // ..
    
    
## Use of the API in your developments

```php
use JLaso\OvhDomainApi\Service\OvhApi;

$ovhUser = "xxxxx-ovh";
$ovhPass = "123456";
define("SANDBOX_MODE", true);
$locale = "en";

$ovhApi = new OvhApi($ovhUser, $ovhPass, SANDBOX_MODE, $locale);

/*
 * To register a new domain 
 */
$ovhApi->registerDomain("example.com", $ovhUser);

/**
 * To check if a domain it's Available
 */
$isAvailable = $ovhApi->isAvailable("example.com");

print ($isAvailable ? 'The domain is AVAILABLE' : 'The Domain is UNAVAILABLE');

/**
 * To create an [ownerId](http://www.ovh.com/soapi/en/?method=nicCreate) (individual) to register domains in this account
 */
$ownerId = $ovhApi->createOwnerId(new OwnerDomain(
    'email@example.com',
    'My Name',
    'My LastName',
    'mypassword1234',
    'My Address',
    'My Area',
    'My City',
    'My Country',
    'My Zip Code',
    'My-Phone-Number',
    'My-fax-or-null'
));

$ovhApi->registerDomain('example.com', $ownerId);
```

You can see the SimpleSample in the Example folder.


More information in the page of [ovh](http://www.ovh.com/soapi/en/)
=======


