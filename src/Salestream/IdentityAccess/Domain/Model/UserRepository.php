<?php

namespace Salestream\IdentityAccess\Domain\Model;

use Salestream\IdentityAccess\Domain\Model\Identity\User;

interface UserRepository
{
    /**
     * @param $tenantId
     * @param $email
     * @return mixed
     */
    public function findUserWithTenantIdAndEmail($tenantId, $email);

    /**
     * @return mixed
     */
    public function nextIdentity();

    /**
     * @param User $user
     * @return mixed
     */
    public function add(User $user);
}