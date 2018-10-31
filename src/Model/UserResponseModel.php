<?php
namespace App\Model;

use App\Entity\User;
use App\Interfaces\IGroup;
use App\Interfaces\IUser;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 23.10.2018
 * Time: 21:31
 */

/**
 * Class UserResponseModel
 * @package App\Model
 */
class UserResponseModel
{
    private $user;

    public function __construct(IUser $user)
    {
        $this->user = $user;

        $this->id = $user->getId();
        $this->username = $user->getUsername();
        $this->email = $user->getEmail();
        $this->registerDate = $user->getRegisterDate();
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
     * @var \DateTime
     * @SWG\Property(description="The register date from the user.", type="DateTime", maxLength=255)
     */
    public $registerDate;

    /**
     * @var Role[]
     */
    public $roles;

    /**
     * @var IGroup
     */
    public $group;
}