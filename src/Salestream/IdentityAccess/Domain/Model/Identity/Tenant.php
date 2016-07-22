<?php

namespace Salestream\IdentityAccess\Domain\Model\Identity;

use Salestream\IdentityAccess\Exception\EmailNotUniqueForTenant;
use Salestream\IdentityAccess\Exception\InactiveTenant;

class Tenant
{
    const ACTIVE = true;
    const INACTIVE = false;

    private $id;
    private $company;
    private $description;
    private $active;
    private $version;

    private $users = [];

    public function __construct($id, $company, $description, $active, $version, array $users = [])
    {
        $this->id = $id;
        $this->company = $company;
        $this->description = $description;
        $this->active = $active;
        $this->version = $version;
        $this->users = $users;
    }

    /**
     * Register user to this tenant
     *
     * @param $userId
     * @param $email
     * @param $password
     * @param $firstName
     * @param $lastName
     * @return User
     * @throws EmailNotUniqueForTenant
     * @throws InactiveTenant
     */
    public function registerUser($userId, $email, $password, $firstName, $lastName)
    {
        if ($this->isInactive())
            throw new InactiveTenant;

        foreach ($this->users as $user) {

            if ($user->getEmail() == $email)

                throw new EmailNotUniqueForTenant;

        }

        $user = new User(
            $userId,
            $this->getId(),
            new Email($email),
            $password,
            User::ENABLED,
            1,
            new Person($userId,
                new Name($firstName, $lastName),
                1));

        $this->users[] = $user;

        return $user;
    }

    /**
     * @param Email $email
     * @return bool|mixed
     */
    public function userWithEmail(Email $email)
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() == $email->getEmail())
                return $user;
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function isActive()
    {
        return $this->active;
    }

    public function isInactive()
    {
        return $this->active ? false : true;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }
}