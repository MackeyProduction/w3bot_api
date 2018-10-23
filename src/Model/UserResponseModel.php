<?php
namespace App\Model;

use App\Entity\User;
use App\Interfaces\IUser;

/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 23.10.2018
 * Time: 21:31
 */

class UserResponseModel implements \Symfony\Component\Security\Core\User\UserInterface
{
    private $user;

    public function __construct(IUser $user)
    {
        $this->user = $user;
    }

    public function getId(): ?int
    {
        return $this->user->getId();
    }

    public function getUsername(): ?string
    {
        return $this->user->getUsername();
    }

    public function getPassword(): ?string
    {
        return $this->user->getPassword();
    }

    public function getEmail(): ?string
    {
        return $this->user->getEmail();
    }

    public function getRegisterDate(): ?\DateTimeInterface
    {
        return $this->user->getRegisterDate();
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->user->getRoles();
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return $this->user->getSalt();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        return $this->user->eraseCredentials();
    }
}