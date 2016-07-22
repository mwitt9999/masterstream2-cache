<?php

namespace Salestream\IdentityAccess\Application\Command\Identity;

use Salestream\IdentityAccess\Application\Command\Command;

final class AuthenticateUser implements Command
{
    private $tenantId;
    private $email;
    private $password;

    public function __construct($tenantId, $email, $password)
    {
        $this->tenantId = $tenantId;
        $this->email = $email;
        $this->password = $password;
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

    private function __clone()
    { }
}