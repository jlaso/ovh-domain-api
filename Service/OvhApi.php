<?php

namespace JLaso\OvhDomainApi\Service;

class OvhApi
{
    const UNKNOWN       = 0;    // Can not retrieve availability of domain
    const AVAILABLE     = 1;    // Domain is available
    const NOT_AVAILABLE = - 1;  // Domain is not available

    const PRODUCTION_MODE = false;
    const SANDBOX_MODE = true;

    /** @var string [User registered in OVH] */
    protected $username;
    /** @var string [Password to access OVH] */
    protected $password;
    /** @var array */
    protected $accessData;
    /** @var bool */
    protected $sandBoxMode;
    /** @var string */
    protected $language;
    protected $session = null;
    /** @var \SoapClient */
    protected $soapClient = null;
    /** @var \SoapFault */
    protected $lastException = null;

    /**
     * @param $user
     * @param $password
     * @param bool   $sandBoxMode
     * @param string $language
     */
    public function __construct($user, $password, $sandBoxMode = true, $language = 'es')
    {
        $this->sandBoxMode = $sandBoxMode;
        $this->language = $language;
        $this->password = $password;
        $this->username = $user;
        $this->accessData = array(
            'hosting'          => 'start1m',
            'offer'            => 'gold',
            'profile'          => 'whiteLabel',
            'owo'              => 'no',
            'owner'            => $user,
            'admin'            => $user,
            'tech'             => $user,
            'billing'          => $user,

            'dns1'             => '',
            'dns2'             => '',
            'dns3'             => '',
            'dns4'             => '',
            'dns5'             => '',

            // only mandatory for .fr domains
            'method'           => '',
            'legalName'        => '',
            'legalNumber'      => '',
            'afnicIdent'       => '',
            'birthDate'        => '',
            'birthCity'        => '',
            'birthDepartement' => '',
            'birthCountry'     => 'ES',   // Country must be in ISO3166

            'dryRun'           => $sandBoxMode,
        );
    }

    /**
     * @param $dnsIndex
     * @param $dnsIP
     * @return $this
     * @throws \Exception
     */
    public function setDns($dnsIndex, $dnsIP)
    {
        if(!in_array($dnsIndex, array(1,2,3,4))){
            throw new \Exception('dns index has to be between 1 and 4');
        }
        $this->accessData[sprintf('dns%d', $dnsIndex)] = $dnsIP;

        return $this;
    }

    public static function doLogin($user, $password, $language = 'en')
    {
        $soap = new \SoapClient("https://www.ovh.com/soapi/soapi-re-1.56.wsdl");
        try {
            $session = $soap->login($user, $password, $language, false);
        } catch (\Exception $e) {
            return array(
                'success' => false,
                'reason' => $e->getMessage(),
            );
        }

        return array(
            'success' => true,
            'session' => $session,
        );
    }

    /**
     * @param string $domain
     *
     * @return int
     */
    public function isAvailable($domain)
    {
        $domain = strtolower(trim($domain));
        $this->login();
        $results = $this->request('domainCheck', array($domain));

        foreach ($results as $result) {
            if ($result->predicate == 'is_available') {
                if ($result->value) {
                    return self::AVAILABLE;
                } else {
                    return self::NOT_AVAILABLE;
                }
            }
        }

        return self::UNKNOWN;
    }

    /**
     * @param OwnerDomain $ownerData
     *
     * @return string
     */
    public function createOwnerId(OwnerDomain $ownerData)
    {
        $result = $this->request('nicCreate', $ownerData->asArray());

        return $result;
    }

    /**
     * @return array
     * @throws \Exception
     * @throws \SoapFault
     */
    public function accountSummary()
    {
        $obj = $this->request('accountSummary');

        return array(
            'nic' => $obj->nic,
            'account' => $obj->account,
            'country' => $obj->country,
            'description' => $obj->description,
            'balance' => $obj->balance,
            'alertThreshold' => $obj->alertThreshold,
            'limitThreshold' => $obj->limitThreshold,
            'openDate' => $obj->openDate,
            'date' => $obj->date,
            'closeDate' => $obj->closeDate,
        );
    }

    /**
     * @param string $domain
     * @param string $ownerId
     *
     * @return bool
     */
    public function registerDomain($domain, $ownerId)
    {
        if ($this->isAvailable($domain)) {
            // http://www.ovh.com/soapi/en/?method=resellerDomainCreate
            $param = array(
                $this->session,
                $domain,
                $this->accessData["hosting"],
                $this->accessData["offer"],
                $this->accessData["profile"],
                $this->accessData["owo"],
                $ownerId, $ownerId, $ownerId, $ownerId,
                "", "", "", "", "", "", "", "", "", "", "", "", "", false, "", "", ""
            );
            call_user_func_array(array($this->soapClient, 'resellerDomainCreate'), $param);
            return true;
        }

        return false;
    }

    /**
     *  PROTECTED METHODS.
     */

    /**
     * logout in ovh.
     */
    protected function login()
    {
        $this->soapClient = new \SoapClient("https://www.ovh.com/soapi/soapi-re-1.56.wsdl");
        $this->session = $this->soapClient->login($this->username, $this->password, $this->language, false);
    }

    /**
     * logout in ovh.
     */
    protected function logout()
    {
        if ($this->soapClient && $this->session) {
            $this->soapClient->logout($this->session);
            $this->session = null;
        }
    }

    /**
     * @param $method
     * @param array $param
     * @param bool  $catchException
     *
     * @return bool|mixed
     *
     * @throws \Exception
     * @throws \SoapFault
     */
    protected function request($method, $param = array(), $catchException = true)
    {
        if (!$this->session) {
            $this->login();
        }
        $this->lastException = null;
        try {

            // add as first parameter the session
            array_unshift($param, $this->session);
            $response = call_user_func_array(array($this->soapClient, $method), $param);
        } catch (\SoapFault $e) {
            if ($catchException) {
                $this->lastException = $e;

                return false;
            } else {
                throw $e;
            }
        }

        return $response;
    }
}
