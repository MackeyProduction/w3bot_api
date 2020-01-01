<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 03.11.2018
 * Time: 15:19
 */

namespace App\Model;

use App\Entity\OperatingSystem;
use App\Entity\Software;
use App\Entity\UserAgent;
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
     * @param UserAgent $userAgent
     */
    public function __construct(UserAgent $userAgent)
    {
        $this->id = $userAgent->getId();
        $this->operatingSystem = OperatingSystemResponseModel::create($userAgent->getOperatingSystem());
        $this->software = SoftwareResponseModel::create($userAgent->getSoftware());
        $this->agent = $userAgent->getAgent();
    }

    /**
     * @param UserAgent $userAgent
     * @return static
     */
    public static function create(UserAgent $userAgent)
    {
        return new static($userAgent);
    }

    /**
     * @var int
     * @SWG\Property(description="The unique identifier of the user agent.")
     */
    public $id;

    /**
     * @var OperatingSystem
     */
    public $operatingSystem;

    /**
     * @var Software
     */
    public $software;

    /**
     * @var string
     * @SWG\Property(type="string", maxLength=255, description="The agent of the software and operating system.")
     */
    public $agent;
}
