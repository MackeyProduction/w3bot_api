<?php
namespace App\Model;

use App\Entity\User;
use App\Interfaces\IRank;
use App\Model\RankResponseModel;
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
    /**
     * UserResponseModel constructor.
     * @param IUser $user
     */
    public function __construct(IUser $user)
    {
        $this->id = $user->getId();
        $this->username = $user->getUsername();
        $this->email = $user->getEmail();
        $this->registerDate = $user->getRegisterDate();
        $this->rank = RankResponseModel::create($user->getRank());
    }

    /**
     * @param IUser $user
     * @return static
     */
    public static function create(IUser $user)
    {
        return new static($user);
    }

    /**
     * @var int
     * @SWG\Property(description="The unique identifier of the user.")
     */
    public $id;

    /**
     * @var string
     * @SWG\Property(type="string", maxLength=255, description="The username from the user.")
     */
    public $username;

    /**
     * @var string
     * @SWG\Property(type="string", maxLength=255, description="The email address from the user.")
     */
    public $email;

    /**
     * @var \DateTime
     * @SWG\Property(type="DateTime", maxLength=255, description="The register date from the user.")
     */
    public $registerDate;

    /**
     * @var IRank
     */
    public $rank;
}