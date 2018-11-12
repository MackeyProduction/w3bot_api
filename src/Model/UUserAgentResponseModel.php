<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 25.10.2018
 * Time: 22:23
 */

namespace App\Model;

use App\Interfaces\IUser;
use App\Interfaces\IUserAgent;
use App\Interfaces\IUUserAgent;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class UUserAgentResponseModel
 * @package App\Model
 */
class UUserAgentResponseModel
{
    /**
     * UUserAgentResponseModel constructor.
     * @param IUser $user
     */
    public function __construct(IUser $user)
    {
        $this->agent = null;
        $this->user = UserResponseModel::create($user);
    }

    /**
     * @var IUserAgent[]
     */
    public $agent;

    /**
     * @var IUser
     */
    public $user;
}
