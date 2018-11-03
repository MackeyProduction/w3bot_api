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
 * Class UUserAgentResponseModel
 * @package App\Model
 */
class UUserAgentResponseModel
{
    /**
     * UUserAgentResponseModel constructor.
     * @param IUUserAgent $userAgent
     */
    public function __construct(IUUserAgent $userAgent)
    {
        $this->id = $userAgent->getId();
        $this->agent = $userAgent->getUserAgent();
        $this->user = $userAgent->getUser();
    }

    /**
     * @var int
     * @SWG\Property(description="The unique identifier of the user agent by user.")
     */
    public $id;

    /**
     * @var IUserAgent
     */
    public $agent;

    /**
     * @var IUser
     */
    public $user;
}
