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
     * @param IUser $userProxy
     */
    public function __construct(IUser $userProxy)
    {
        $this->proxy = $userProxy->getUp();
        $this->user = UserResponseModel::create($userProxy);
    }

    /**
     * @var IProxy
     */
    public $proxy;

    /**
     * @var IUser
     */
    public $user;
}
