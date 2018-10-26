<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 25.10.2018
 * Time: 22:23
 */

namespace App\Model;

use App\Entity\UUA;
use App\Interfaces\IUser;
use App\Interfaces\IUserAgent;
use App\Interfaces\IUUserAgent;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class UserAgentResponseModel
 * @package App\Model
 */
class UserAgentResponseModel
{
    private $userAgent;

    /**
     * UserAgentResponseModel constructor.
     * @param IUUserAgent $userAgent
     */
    public function __construct(IUUserAgent $userAgent)
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @var IUserAgent
     */
    public $agent;

    /**
     * @var IUser
     */
    public $user;
}
