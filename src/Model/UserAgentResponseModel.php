<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 25.10.2018
 * Time: 22:23
 */

namespace App\Model;

use App\Entity\UUA;
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
     * @SWG\Property(ref=@Model(type=UUA::class))
     */
    public $agent;

    /**
     * @SWG\Property(ref=@Model(type=User::class))
     */
    public $user;
}
