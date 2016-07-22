<?php

namespace Salestream\IdentityAccess\Domain\Model;

interface EncryptionService
{
    /**
     * @param $password
     * @return string | false
     */
    public function hashPassword($password);

    /**
     * @param $password
     * @param $passwordHash
     * @return true | false
     */
    public function verifyPassword($password, $passwordHash);
}