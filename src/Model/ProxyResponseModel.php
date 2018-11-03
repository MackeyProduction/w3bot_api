<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 03.11.2018
 * Time: 15:19
 */

namespace App\Model;

use App\Interfaces\IProxy;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class ProxyResponseModel
 * @package App\Model
 */
class ProxyResponseModel
{
    /**
     * ProxyResponseModel constructor.
     * @param IProxy $proxy
     */
    public function __construct(IProxy $proxy)
    {
        $this->id = $proxy->getId();
        $this->name = $proxy->getUsername();
        $this->ip = $proxy->getIP();
        $this->port = $proxy->getPort();
        $this->username = $proxy->getUsername();
        $this->password = $proxy->getPassword();
    }

    /**
     * @var int
     * @SWG\Property(description="The unique identifier of the proxy.")
     */
    public $id;

    /**
     * @var string
     * @SWG\Property(description="The name of the proxy.")
     */
    public $name;

    /**
     * @var string
     * @SWG\Property(description="The ip address of the proxy.")
     */
    public $ip;

    /**
     * @var int
     * @SWG\Property(description="The port of the proxy.")
     */
    public $port;

    /**
     * @var string
     * @SWG\Property(description="The username of the proxy.")
     */
    public $username;

    /**
     * @var string
     * @SWG\Property(description="The password of the proxy.")
     */
    public $password;
}