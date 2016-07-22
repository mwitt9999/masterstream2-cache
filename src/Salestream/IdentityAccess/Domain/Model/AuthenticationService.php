<?php

namespace Salestream\IdentityAccess\Domain\Model;

use Salestream\IdentityAccess\Exception\InactiveTenant;
use Salestream\IdentityAccess\Exception\TenantNotFound;
use Salestream\IdentityAccess\Exception\UserNotFound;
use Salestream\IdentityAccess\Exception\UserDisabled;

use Salestream\IdentityAccess\Domain\Model\Identity\Email;

class AuthenticationService
{
    private $encryptionService;
    private $tenantRepository;

    public function __construct(EncryptionService $encryptionService, TenantRepository $tenantRepository)
    {
        $this->encryptionService = $encryptionService;
        $this->tenantRepository = $tenantRepository;
    }

    public function authenticate($tenantId, $email, $password)
    {
        $tenant = $this->tenantRepository()
            ->findTenantAndUsersById($tenantId);

        if ($tenant === null)
            throw new TenantNotFound;

        if ($tenant->isInactive())
            throw new InactiveTenant;

        $user = $tenant->userWithEmail(new Email($email));

        if ($user === null)
            throw new UserNotFound;

        if ($user->isDisabled())
            throw new UserDisabled;

        if ($this->encryptionService()->verifyPassword($password, $user->getPassword()))
            return $user->userDetails();

        return false;
    }

    public function encryptionService()
    {
        return $this->encryptionService;
    }

    public function tenantRepository()
    {
        return $this->tenantRepository;
    }
}