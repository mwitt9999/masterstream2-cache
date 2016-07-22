<?php

namespace Salestream\IdentityAccess\Application\Command\Identity;

use Salestream\IdentityAccess\Application\Command\Command;

final class RegisterUser implements Command
{
    private $tenantId;
    private $email;
    private $password;
    private $firstName;
    private $lastName;

    public function __construct($tenantId, $email, $password, $firstName, $lastName)
    {
        $this->tenantId = $tenantId;
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getTenantId()
    {
        return $this->tenantId;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    private function __clone()
    { }
}