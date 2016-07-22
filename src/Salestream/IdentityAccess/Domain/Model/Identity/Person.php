<?php

namespace Salestream\IdentityAccess\Domain\Model\Identity;

class Person
{
    private $id;
    private $name;
    private $version;

    public function __construct($id, Name $name, $version)
    {
        $this->id = $id;
        $this->name = $name;
        $this->version = $version;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->name->getFirstName();
    }

    public function getLastName()
    {
        return $this->name->getLastName();
    }

    public function getVersion()
    {
        return $this->version;
    }
}