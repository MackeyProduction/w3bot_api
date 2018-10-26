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

class ProxyResponseModel
{
    private $userProxy;

    /**
     * ProxyResponseModel constructor.
     * @param IUProxy $userProxy
     */
    public function __construct(IUProxy $userProxy)
    {
        $this->userProxy = $userProxy;
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
