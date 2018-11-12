<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 03.11.2018
 * Time: 15:19
 */

namespace App\Model;

use App\Interfaces\IOperatingSystem;
use App\Interfaces\ISoftware;
use App\Interfaces\IUserAgent;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class UserAgentResponseModel
 * @package App\Model
 */
class UserAgentResponseModel
{
    /**
     * UserAgentResponseModel constructor.
     * @param IUserAgent $userAgent
     */
    public function __construct(IUserAgent $userAgent)
    {
        $this->id = $userAgent->getId();
        $this->operatingSystem = OperatingSystemResponseModel::create($userAgent->getOperatingSystem());
        $this->software = SoftwareResponseModel::create($userAgent->getSoftware());
    }

    /**
     * @param IUserAgent $userAgent
     * @return static
     */
    public static function create(IUserAgent $userAgent)
    {
        return new static($userAgent);
    }

    /**
     * @var int
     * @SWG\Property(description="The unique identifier of the user agent.")
     */
    public $id;

    /**
     * @var IOperatingSystem
     */
    public $operatingSystem;

    /**
     * @var ISoftware
     */
    public $software;
}
