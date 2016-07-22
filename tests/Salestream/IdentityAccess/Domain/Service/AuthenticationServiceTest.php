<?php

use PHPUnit\Framework\TestCase;
use Mockery as m;

use Salestream\IdentityAccess\Domain\Model\AuthenticationService;
use Salestream\IdentityAccess\Domain\Model\Identity\Tenant;
use Salestream\IdentityAccess\Domain\Model\Identity\User;
use Salestream\IdentityAccess\Domain\Model\Identity\Email;
use Salestream\IdentityAccess\Domain\Model\Identity\Person;
use Salestream\IdentityAccess\Domain\Model\Identity\Name;

class AuthenticationServiceTest extends TestCase
{
    const TENANT_ID  = '601219e-8e9e-43b9-b210-962c93764af7';
    const TENANT_ACTIVE = 1;
    const TENANT_INACTIVE = 0;
    const COMPANY = 'Salestream Software, Inc';
    const DESCRIPTION = 'The default tenant';
    const TENANT_VERSION = 1;

    const USER_ID         = 'b09255b4-4d32-11e6-beb8-9e71128cae77';
    const USER_TENANT_ID  = self::TENANT_ID;
    const EMAIL      = 'rreed@salestreamsoft.com';
    const PASSWORD   = 'Abcd1234';
    const PASSWORD_HASH = '$2y$10$aptuJtWzeUSohfAWTfZD.ef5DH1usPhqFn0couxG58Vtb7Xo7iEzm';
    const FIRST_NAME = 'Ricky';
    const LAST_NAME  = 'Reed';
    const USER_ENABLED = 1;
    const USER_VERSION    = 1;

    public function test_can_create_instance_of_authentication_service()
    {
        $mockEncryptionService = m::mock('Salestream\IdentityAccess\Domain\Model\EncryptionService');
        $mockTenantRepository = m::mock('Salestream\IdentityAccess\Domain\Model\TenantRepository');

        $authenticationService = new AuthenticationService($mockEncryptionService, $mockTenantRepository);

        $this->assertNotNull($authenticationService);
    }

    public function test_can_authenticate_user()
    {
        $tenant = $this->getActiveTenant();

        $mockEncryptionService = m::mock('Salestream\IdentityAccess\Domain\Model\EncryptionService');
        $mockEncryptionService->shouldReceive('verifyPassword')
            ->times(1)
            ->andReturn(true);

        $mockTenantRepository = m::mock('Salestream\IdentityAccess\Domain\Model\TenantRepository');
        $mockTenantRepository->shouldReceive('findTenantAndUsersById')
            ->times(1)
            ->andReturn($tenant);

        $authenticationService = new AuthenticationService($mockEncryptionService, $mockTenantRepository);
        try {
            $userDetails = $authenticationService->authenticate(self::TENANT_ID, 'jorden@gmail.com', self::PASSWORD);
        } catch(\Exception $e) {
            $this->assertTrue(false);
        }

        $this->assertTrue($userDetails instanceof Salestream\IdentityAccess\Domain\Model\Identity\UserDetails);
        $this->assertEquals(self::TENANT_ID, $userDetails->getTenantId());
        $this->assertEquals('cbb60520-4dcd-11e6-beb8-9e71128cae77', $userDetails->getUserId());
    }

    /**
     * @expectedException Salestream\IdentityAccess\Exception\TenantNotFound
     */
    public function test_will_throw_tenant_not_found_exception()
    {
        $mockEncryptionService = m::mock('Salestream\IdentityAccess\Domain\Model\EncryptionService');
        $mockEncryptionService->shouldReceive('verifyPassword')
            ->times(0);

        $mockTenantRepository = m::mock('Salestream\IdentityAccess\Domain\Model\TenantRepository');
        $mockTenantRepository->shouldReceive('findTenantAndUsersById')
            ->times(1)
            ->andReturnNull();

        $authenticationService = new AuthenticationService($mockEncryptionService, $mockTenantRepository);

        $authenticationService->authenticate(self::TENANT_ID, 'jorden@gmail.com', self::PASSWORD);
    }

    /**
     * @expectedException Salestream\IdentityAccess\Exception\UserNotFound
     */
    public function test_will_throw_user_not_found_exception()
    {
        $tenant = $this->getActiveTenant();

        $mockEncryptionService = m::mock('Salestream\IdentityAccess\Domain\Model\EncryptionService');
        $mockEncryptionService->shouldReceive('verifyPassword')
            ->times(0);

        $mockTenantRepository = m::mock('Salestream\IdentityAccess\Domain\Model\TenantRepository');
        $mockTenantRepository->shouldReceive('findTenantAndUsersById')
            ->times(1)
            ->andReturn($tenant);

        $authenticationService = new AuthenticationService($mockEncryptionService, $mockTenantRepository);

        $authenticationService->authenticate(self::TENANT_ID, self::EMAIL, self::PASSWORD);
    }

    /**
     * @expectedException Salestream\IdentityAccess\Exception\UserDisabled
     */
    public function test_will_throw_user_disabled_exception()
    {
        $tenant = $this->getActiveTenant();

        $mockEncryptionService = m::mock('Salestream\IdentityAccess\Domain\Model\EncryptionService');
        $mockEncryptionService->shouldReceive('verifyPassword')
            ->times(0);

        $mockTenantRepository = m::mock('Salestream\IdentityAccess\Domain\Model\TenantRepository');
        $mockTenantRepository->shouldReceive('findTenantAndUsersById')
            ->times(1)
            ->andReturn($tenant);

        $authenticationService = new AuthenticationService($mockEncryptionService, $mockTenantRepository);

        $authenticationService->authenticate(self::TENANT_ID, 'keith@yahoo.com', self::PASSWORD);
    }

    private function getActiveTenant()
    {
        return new Tenant(self::TENANT_ID, self::COMPANY, self::DESCRIPTION, self::TENANT_ACTIVE, self::TENANT_VERSION, $this->getUsersForTenant());
    }

    private function getInactiveTenant()
    {
        return new Tenant(self::TENANT_ID, self::COMPANY, self::DESCRIPTION, self::TENANT_INACTIVE, self::TENANT_VERSION, $this->getUsersForTenant());
    }

    private function getUsersForTenant()
    {
        $users = [];

        $user1 = new User('cbb5fddc-4dcd-11e6-beb8-9e71128cae77', self::TENANT_ID, new Email('eneisha@gmail.com'), self::PASSWORD_HASH, User::ENABLED, 1, new Person('cbb5fddc-4dcd-11e6-beb8-9e71128cae77', new Name('Eneisha', 'Reed'), 1));
        $user2 = new User('cbb60520-4dcd-11e6-beb8-9e71128cae77', self::TENANT_ID, new Email('jorden@gmail.com'), self::PASSWORD_HASH, User::ENABLED, 1, new Person('cbb60520-4dcd-11e6-beb8-9e71128cae77', new Name('Jorden', 'Reed'), 1));
        $user3 = new User('cbb60796-4dcd-11e6-beb8-9e71128cae77', self::TENANT_ID, new Email('jaidynn@gmail.com'), self::PASSWORD_HASH, User::ENABLED, 1, new Person('cbb60796-4dcd-11e6-beb8-9e71128cae77', new Name('Jaidynn', 'Reed'), 1));
        $user4 = new User('cbb60976-4dcd-11e6-beb8-9e71128cae77', self::TENANT_ID, new Email('jacob@gmail.com'), self::PASSWORD_HASH, User::ENABLED, 1, new Person('cbb60976-4dcd-11e6-beb8-9e71128cae77', new Name('Jacob', 'Reed'), 1));
        $user5 = new User('cbb60b24-4dcd-11e6-beb8-9e71128cae77', self::TENANT_ID, new Email('joel@yahoo.com'), self::PASSWORD_HASH, User::ENABLED, 1, new Person('cbb60b24-4dcd-11e6-beb8-9e71128cae77', new Name('Joel', 'Reed'), 1));
        $user5 = new User('b7e4ae02-4e36-11e6-beb8-9e71128cae77', self::TENANT_ID, new Email('keith@yahoo.com'), self::PASSWORD_HASH, User::DISABLED, 1, new Person('b7e4ae02-4e36-11e6-beb8-9e71128cae77', new Name('Keith', 'Reed'), 1));

        $users[] = $user1;
        $users[] = $user2;
        $users[] = $user3;
        $users[] = $user4;
        $users[] = $user5;

        return $users;
    }
}