<?php

namespace Salestream\IdentityAccess\Domain\Model\Identity;

class User
{
    const ENABLED = 1;
    const DISABLED = 0;

    private $id;
    private $tenantId;
    private $email;
    private $password;
    private $enabled;
    private $version;

    private $person;

    public function __construct($id, $tenantId, Email $email, $password, $enabled, $version, Person $person)
    {
        $this->id = $id;
        $this->tenantId = $tenantId;
        $this->email = $email;
        $this->password = $password;
        $this->enabled = $enabled;
        $this->version = $version;
        $this->person = $person;
    }

    public function userDetails()
    {
        return new UserDetails(
            $this->tenantId,
            $this->getId(),
            $this->getEmail(),
            $this->getPerson()
                ->getFirstName(),
            $this->getPerson()
                ->getLastName());
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email->getEmail();
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    public function isDisabled()
    {
        return $this->enabled ? false : true;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    public function getPerson()
    {
        return $this->person;
    }
}