<?php

use PHPUnit\Framework\TestCase;

use Salestream\IdentityAccess\Domain\Model\Identity\Name;
use Salestream\IdentityAccess\Domain\Model\Identity\Tenant;
use Salestream\IdentityAccess\Domain\Model\Identity\User;
use Salestream\IdentityAccess\Domain\Model\Identity\Email;
use Salestream\IdentityAccess\Domain\Model\Identity\Person;

class TenantTest extends TestCase
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

    public function test_can_register_new_user()
    {
        $tenant = $this->getActiveTenant();

        $user = $tenant->registerUser(self::USER_ID, self::EMAIL, self::PASSWORD_HASH, self::FIRST_NAME, self::LAST_NAME);

        $this->assertTrue($user instanceof Salestream\IdentityAccess\Domain\Model\Identity\User);
        $this->assertEquals(self::USER_ID, $user->getId());
        $this->assertEquals(self::TENANT_ID, $user->getTenantId());
        $this->assertEquals(self::EMAIL, $user->getEmail());
    }

    /**
     * @expectedException Salestream\IdentityAccess\Exception\InactiveTenant
     */
    public function test_will_throw_in_active_tenant_exception()
    {
        $tenant = $this->getInActiveTenant();

        $tenant->registerUser(self::USER_ID, self::EMAIL, self::PASSWORD_HASH, self::FIRST_NAME, self::LAST_NAME);
    }

    /**
     * @expectedException Salestream\IdentityAccess\Exception\EmailNotUniqueForTenant
     */
    public function test_will_throw_email_not_unique_for_tenant_exception()
    {
        $tenant = $this->getActiveTenant();

        $duplicateEmail = 'jorden@gmail.com';

        $tenant->registerUser(self::USER_ID, $duplicateEmail, self::PASSWORD_HASH, self::FIRST_NAME, self::LAST_NAME);
    }

    private function getActiveTenant()
    {
        return new Tenant(self::TENANT_ID, self::COMPANY, self::DESCRIPTION, self::TENANT_ACTIVE, self::TENANT_VERSION, $this->getUsersForTenant());
    }

    private function getInActiveTenant()
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

        $users[] = $user1;
        $users[] = $user2;
        $users[] = $user3;
        $users[] = $user4;
        $users[] = $user5;

        return $users;
    }
}