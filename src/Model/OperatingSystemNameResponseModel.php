<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 12.11.2018
 * Time: 16:15
 */

namespace App\Model;

use App\Entity\OperatingSystemName;

/**
 * Class OperatingSystemNameResponseModel
 * @package App\Model
 */
class OperatingSystemNameResponseModel
{
    /**
     * OperatingSystemNameResponseModel constructor.
     * @param OperatingSystemName $operatingSystemName
     */
    public function __construct(OperatingSystemName $operatingSystemName)
    {
        $this->id = $operatingSystemName->getId();
        $this->name = $operatingSystemName->getName();
    }

    /**
     * @param OperatingSystemName $operatingSystemName
     * @return static
     */
    public static function create(OperatingSystemName $operatingSystemName)
    {
        return new static($operatingSystemName);
    }

    /**
     * @var int
     * @SWG\Property(type="string", maxLength=255, description="The unique identifier of operating system name.")
     */
    public $id;

    /**
     * @var string
     * @SWG\Property(type="string", maxLength=255, description="The name of the operating system.")
     */
    public $name;
}