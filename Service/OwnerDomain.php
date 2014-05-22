<?php

namespace JLaso\OvhDomainApi\Service;


class OwnerDomain
{
    protected $name;
    protected $firstname;
    protected $password;
    protected $email;
    protected $phone;
    protected $fax;
    protected $address;
    protected $city;
    protected $area;
    protected $zip;
    protected $country; // (be|fr|pl|es|lu|ch|de|...)
    protected $language = 'es'; //  (fr|en|pl|es|de)
    protected $isOwner = true;
    protected $legalForm; // forma jurídica del contacto (corporation|individual|association|other)
    protected $organisation;
    protected $legalName;
    protected $legalNumber; // el número legal de contacto (CIF/NIF/...)
    protected $vat; // el n.IVA contacto

    function __construct(
        $email, $name, $firstname, $password,
        $address, $area, $city, $country, $zip,
        $phone, $fax,
        $organisation = '', $legalName = '', $legalNumber = '', $vat = '', $legalForm = 'individual'
    )
    {
        $this->address = $address;
        $this->area = $area;
        $this->city = $city;
        $this->country = $country;
        $this->email = $email;
        $this->fax = $fax;
        $this->firstname = $firstname;
        $this->legalForm = $legalForm;
        $this->legalName = $legalName;
        $this->legalNumber = $legalNumber;
        $this->name = $name;
        $this->organisation = $organisation;
        $this->password = $password;
        $this->phone = $phone;
        $this->vat = $vat;
        $this->zip = $zip;
    }

    function asArray()
    {
        return array(
            'session'      => $this->session,         // ID de la sesión
            'name'         => $this->name,            // nombre del contacto
            'firstname'    => $this->firstname,       // apellido del contacto
            'password'     => $this->password,        // contraseña del contacto
            'email'        => $this->email,           // email del contacto
            'phone'        => $this->phone,           // número de teléfono del contacto (formato internacional, ej: +33.899701761)
            'fax'          => $this->fax,             // número de fax del contacto
            'address'      => $this->address,         // dirección del contacto
            'city'         => $this->city,            // ciudad del contacto
            'area'         => $this->area,            // área del contacto
            'zip'          => $this->zip,             // el código postal contacto
            'country'      => $this->country,         // país del contacto (be|fr|pl|es|lu|ch|de|...)
            'language'     => $this->language,        // idioma del contacto (fr|en|pl|es|de)
            'isOwner'      => $this->isOwner,         // ¿es un nic propietario ? por defecto, falso
            'legalform'    => $this->legalform,       // forma jurídica del contacto (corporation|individual|association|other)
            'organisation' => $this->organisation,    // nombre organización
            'legalName'    => $this->legalName,       // nombre legal del contacto
            'legalNumber'  => $this->legalNumber,     // el número legal de contacto (CIF/NIF/...)
            'vat'          => $this->vat,             // el n.IVA contacto
        );
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $area
     */
    public function setArea($area)
    {
        $this->area = $area;
    }

    /**
     * @return mixed
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param boolean $isOwner
     */
    public function setIsOwner($isOwner)
    {
        $this->isOwner = $isOwner;
    }

    /**
     * @return boolean
     */
    public function getIsOwner()
    {
        return $this->isOwner;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $legalForm
     */
    public function setLegalForm($legalForm)
    {
        $this->legalForm = $legalForm;
    }

    /**
     * @return mixed
     */
    public function getLegalForm()
    {
        return $this->legalForm;
    }

    /**
     * @param mixed $legalName
     */
    public function setLegalName($legalName)
    {
        $this->legalName = $legalName;
    }

    /**
     * @return mixed
     */
    public function getLegalName()
    {
        return $this->legalName;
    }

    /**
     * @param mixed $legalNumber
     */
    public function setLegalNumber($legalNumber)
    {
        $this->legalNumber = $legalNumber;
    }

    /**
     * @return mixed
     */
    public function getLegalNumber()
    {
        return $this->legalNumber;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $organisation
     */
    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;
    }

    /**
     * @return mixed
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $vat
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }

    /**
     * @return mixed
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * @param mixed $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }




}