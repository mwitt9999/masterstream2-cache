<?php

namespace Salestream\IdentityAccess\Application;

use Salestream\IdentityAccess\Application\Command\Identity\AuthenticateUser;
use Salestream\IdentityAccess\Application\Command\Identity\RegisterUser;
use Salestream\IdentityAccess\Domain\Model\AuthenticationService;
use Salestream\IdentityAccess\Domain\Model\EncryptionService;
use Salestream\IdentityAccess\Domain\Model\TenantRepository;
use Salestream\IdentityAccess\Domain\Model\UserRepository;
use Salestream\IdentityAccess\Exception\TenantNotFound;

class DefaultIdentityAccessApplicationService implements IdentityAccessApplicationService
{
    private $authenticationService;
    private $encryptionService;
    private $tenantRepository;
    private $userRepository;

    public function __construct(AuthenticationService $authenticationService,
                                EncryptionService $encryptionService,
                                TenantRepository $tenantRepository,
                                UserRepository $userRepository)
    {
        $this->authenticationService = $authenticationService;
        $this->encryptionService = $encryptionService;
        $this->tenantRepository = $tenantRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param RegisterUser $command
     * @return bool
     * @throws TenantNotFound
     * @throws \Exception
     */
    public function registerUser(RegisterUser $command)
    {
        $tenant = $this->tenantRepository()
            ->findTenantAndUsersById($command->getTenantId());

        if ($tenant === null)
            throw new TenantNotFound;

        $userId = $this->userRepository()->nextIdentity();

        $encryptedPassword = $this->encryptionService()
            ->hashPassword($command->getPassword());

        if ($encryptedPassword === false)
            throw new \Exception('Failed encrypting the user password');

        $user = $tenant->registerUser(
            $userId,
            $command->getEmail(),
            $encryptedPassword,
            $command->getFirstName(),
            $command->getLastName());

        if ($this->userRepository()->add($user)) {
            return true;
        }

        return false;
    }

    /**
     * @param AuthenticateUser $command
     * @return bool
     */
    public function authenticateUser(AuthenticateUser $command)
    {
        $userDetails = $this->authenticationService()
            ->authenticate($command->getTenantId(),
                $command->getEmail(),
                $command->getPassword());

        return $userDetails;
    }

    private function authenticationService()
    {
        return $this->authenticationService;
    }

    private function encryptionService()
    {
        return $this->encryptionService;
    }

    private function tenantRepository()
    {
        return $this->tenantRepository;
    }

    private function userRepository()
    {
        return $this->userRepository;
    }
}
