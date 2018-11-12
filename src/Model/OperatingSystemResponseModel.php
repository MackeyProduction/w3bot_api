<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 12.11.2018
 * Time: 16:09
 */

namespace App\Model;

use App\Interfaces\IOperatingSystem;
use App\Interfaces\IOperatingSystemName;
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
     * @param IOperatingSystem $operatingSystem
     */
    public function __construct(IOperatingSystem $operatingSystem)
    {
        $this->id = $operatingSystem->getId();
        $this->operatingSystemName = OperatingSystemNameResponseModel::create($operatingSystem->getOperatingSystemName());
        $this->version = $operatingSystem->getVersion();
    }

    /**
     * @param IOperatingSystem $operatingSystem
     * @return static
     */
    public static function create(IOperatingSystem $operatingSystem)
    {
        return new static($operatingSystem);
    }

    /**
     * @var int
     * @SWG\Property(description="The unique identifier of the operating system.")
     */
    public $id;

    /**
     * @var IOperatingSystemName
     */
    public $operatingSystemName;

    /**
     * @var string
     * @SWG\Property(type="string", maxLength=255, description="The version of the operating system.")
     */
    public $version;
}