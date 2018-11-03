<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 25.10.2018
 * Time: 23:09
 */

namespace App\Model;

use App\Interfaces\IProxy;
use App\Interfaces\IUProxy;
use App\Interfaces\IUser;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class UProxyResponseModel
{
    /**
     * UProxyResponseModel constructor.
     * @param IUProxy $userProxy
     */
    public function __construct(IUProxy $userProxy)
    {
        $this->id = $userProxy->getId();
        $this->proxy = $userProxy->getProxy();
        $this->user = $userProxy->getUser();
    }

    /**
     * @var int
     * @SWG\Property(description="The unique identifier of the proxy.", type="integer", maxLength=255)
     */
    public $id;

    /**
     * @var IProxy
     */
    public $proxy;

    /**
     * @var IUser
     */
    public $user;
}
