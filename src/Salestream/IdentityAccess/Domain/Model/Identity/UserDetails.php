<?php

namespace Salestream\IdentityAccess\Domain\Model\Identity;

class UserDetails
{
    private $tenantId;
    private $userId;
    private $email;
    private $firstName;
    private $lastName;

    public function __construct($tenantId, $userId, $email, $firstName, $lastName)
    {
        $this->tenantId = $tenantId;
        $this->userId = $userId;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
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
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}