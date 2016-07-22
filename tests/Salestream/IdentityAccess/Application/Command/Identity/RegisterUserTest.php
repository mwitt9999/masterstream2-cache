<?php

use PHPUnit\Framework\TestCase;

use Salestream\IdentityAccess\Application\Command\Identity\RegisterUser;

class RegisterUserTest extends TestCase
{
    const TENANT_ID  = '601219e-8e9e-43b9-b210-962c93764af7';
    const EMAIL      = 'rreed@salestreamsoft.com';
    const PASSWORD   = 'Abcd1234';
    const FIRST_NAME = 'Ricky';
    const LAST_NAME  = 'Reed';

    private $command;

    public function setUp()
    {
        parent::setUp();

        $this->command = new RegisterUser(
            self::TENANT_ID,
            self::EMAIL,
            self::PASSWORD,
            self::FIRST_NAME,
            self::LAST_NAME
        );
    }

    public function test_can_create_register_user()
    {
        $this->assertNotNull($this->command);
    }

    public function test_can_get_tenant_id()
    {
        $this->assertEquals(self::TENANT_ID, $this->command->getTenantId());
    }

    public function test_can_get_email()
    {
        $this->assertEquals(self::EMAIL, $this->command->getEmail());
    }

    public function test_can_get_password()
    {
        $this->assertEquals(self::PASSWORD, $this->command->getPassword());
    }

    public function test_can_get_first_name()
    {
        $this->assertEquals(self::FIRST_NAME, $this->command->getFirstName());
    }

    public function test_can_get_last_name()
    {
        $this->assertEquals(self::LAST_NAME, $this->command->getLastName());
    }
}