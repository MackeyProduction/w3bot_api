<?php
namespace App\Model;

use App\Entity\User;
use App\Interfaces\IUser;
use Symfony\Component\Security\Core\User\UserInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 23.10.2018
 * Time: 21:31
 */

class UserResponseModel implements UserInterface
{
    private $user;

    public function __construct(IUser $user)
    {
        $this->user = $user;

        $this->id = $user->getId();
        $this->username = $user->getUsername();
        $this->registerDate = $user->getRegisterDate();
        $this->roles = $this->getRoles();
    }

    /**
     * @var int
     * @SWG\Property(description="The unique identifier of the user.")
     */
    public $id;

    /**
     * @var string
     * @SWG\Property(description="The username from the user.", type="string", maxLength=255)
     */
    public $username;

    /**
     * @var string
     * @SWG\Property(description="The email address from the user.", type="string", maxLength=255)
     */
    public $email;

    /**
     * @var string
     * @SWG\Property(description="The register date from the user.", type="string", maxLength=255)
     */
    public $registerDate;

    /**
     * @var array
     * @SWG\Property(description="The roles from the user.", type="string", maxLength=255)
     */
    public $roles;

    public function getUsername(): ?string
    {
        return $this->user->getUsername();
    }

    public function getPassword(): ?string
    {
        return $this->user->getPassword();
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
     * @SWG\Property(description="The register date from the user.", type="string", maxLength=255)
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