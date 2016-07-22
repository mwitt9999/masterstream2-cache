<?php

namespace Salestream\IdentityAccess\Domain\Model;

use Salestream\IdentityAccess\Domain\Model\Identity\Tenant;

interface TenantRepository
{
    /**
     * @param $id
     * @return Tenant
     */
    public function findTenantAndUsersById($id);

    /**
     * @return mixed
     */
    public function nextIdentity();
}