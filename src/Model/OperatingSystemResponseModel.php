<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 12.11.2018
 * Time: 16:09
 */

namespace App\Model;

use App\Entity\OperatingSystem;
use App\Entity\OperatingSystemName;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class OperatingSystemResponseModel
 * @package App\Model
 */
class OperatingSystemResponseModel
{
    /**
     * OperatingSystemResponseModel constructor.
     * @param OperatingSystem $operatingSystem
     */
    public function __construct(OperatingSystem $operatingSystem)
    {
        $this->id = $operatingSystem->getId();
        $this->operatingSystemName = OperatingSystemNameResponseModel::create($operatingSystem->getOperatingSystemName());
        $this->version = $operatingSystem->getVersion();
    }

    /**
     * @param OperatingSystem $operatingSystem
     * @return static
     */
    public static function create(OperatingSystem $operatingSystem)
    {
        return new static($operatingSystem);
    }

    /**
     * @var int
     * @SWG\Property(description="The unique identifier of the operating system.")
     */
    public $id;

    /**
     * @var OperatingSystemName
     */
    public $operatingSystemName;

    /**
     * @var string
     * @SWG\Property(type="string", maxLength=255, description="The version of the operating system.")
     */
    public $version;
}