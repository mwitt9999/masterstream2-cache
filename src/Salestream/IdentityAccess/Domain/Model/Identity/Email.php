<?php

namespace Salestream\IdentityAccess\Domain\Model\Identity;

class Email
{
    private $emailAddress;

    public function __construct($emailAddress)
    {
        $this->setEmail($emailAddress);
    }

    private function setEmail($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    public function getEmail()
    {
        return $this->emailAddress;
    }
}