<?php

namespace Salestream\IdentityAccess\Domain\Model\Identity;

final class TenantId
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}