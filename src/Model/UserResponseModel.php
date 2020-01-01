<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 23.10.2018
 * Time: 21:31
 */

namespace App\Model;

use App\Entity\Rank;
use App\Entity\User;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class UserResponseModel
 * @package App\Model
 */
class UserResponseModel
{
    /**
     * UserResponseModel constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->id = $user->getId();
        $this->username = $user->getUsername();
        $this->email = $user->getEmail();
        $this->registerDate = $user->getRegisterDate();
        $this->rank = RankResponseModel::create($user->getRank());
    }

    /**
     * @param User $user
     * @return static
     */
    public static function create(User $user)
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
     * @var Rank
     */
    public $rank;
}