<?php

require __DIR__ . '/config.php';
use JLaso\OvhDomainApi\Service\OvhApi;
use JLaso\OvhDomainApi\Service\OwnerDomain;

class OvhDomainTest extends PHPUnit_Framework_TestCase
{

    /** @var \JLaso\OvhDomainApi\Service\OvhApi  */
    private $api;

    const SANDBOX_MODE = true;

    function __construct()
    {
        $this->api = new OvhApi(OVH_USER, OVH_PASS, self::SANDBOX_MODE, 'es');
    }


    public function testDomainExists()
    {
        $this->assertEquals($this->api->isAvailable('google.com'), OvhApi::NOT_AVAILABLE);
    }

    public function testDomainNotExists()
    {
        // normally a domain invented don't exists, not ?
        $domain = "d".uniqid().".com";
        $this->assertEquals($this->api->isAvailable($domain), OvhApi::AVAILABLE);
    }

    public function testBuyDomain()
    {
        $domain = "php.ki";
        $owner = new OwnerDomain(
            'email@example.com', 'Owner Name', 'FirstName', 'p4$Sw0rd',
            'Address line', 'Area', 'Madrid', 'es', '28001', 'phone', 'fax'
        );
        $this->assertTrue($this->api->registerDomain($domain, $owner));
    }

}