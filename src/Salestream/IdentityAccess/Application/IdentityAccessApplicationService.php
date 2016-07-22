<?php

namespace Salestream\IdentityAccess\Application;

use Salestream\IdentityAccess\Application\Command\Identity\AuthenticateUser;
use Salestream\IdentityAccess\Application\Command\Identity\RegisterUser;

interface IdentityAccessApplicationService
{
    /**
     * @param RegisterUser $command
     * @return mixed
     */
    public function registerUser(RegisterUser $command);

    /**
     * @param AuthenticateUser $command
     * @return mixed
     */
    public function authenticateUser(AuthenticateUser $command);
}