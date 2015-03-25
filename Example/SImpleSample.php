<?php

namespace JLaso\OvhDomainApi\Service;

use JLaso\OvhDomainApi\Service\OvhApi;

define("OVH_USER", "xxxxx-ovh");
define("OVH_PASS", "123456");
define("SANDBOX_MODE", true);
define("LOCALE", "en");

$ovhApi = new OvhApi(OVH_USER, OVH_PASS, SANDBOX_MODE, LOCALE);

/*
 * Register a new domain
 */
$ovhApi->registerDomain("example.com", OVH_USER);

/**
 * Check if domain is Available
 */
$isAvailable = $ovhApi->isAvailable("example.com");

print ($isAvailable ? 'The domain is AVAILABLE' : 'The Domain is UNAVAILABLE');

/**
 * Create an ownerId (individual) to register domains
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