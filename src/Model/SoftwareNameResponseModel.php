<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 12.11.2018
 * Time: 16:40
 */

namespace App\Model;

use App\Interfaces\ISoftwareName;

/**
 * Class SoftwareNameResponseModel
 * @package App\Model
 */
class SoftwareNameResponseModel
{
    /**
     * SoftwareNameResponseModel constructor.
     * @param ISoftwareName $softwareName
     */
    public function __construct(ISoftwareName $softwareName)
    {
        $this->id = $softwareName->getId();
        $this->name = $softwareName->getName();
    }

    /**
     * @param ISoftwareName $softwareName
     * @return static
     */
    public static function create(ISoftwareName $softwareName)
    {
        return new static($softwareName);
    }

    /**
     * @var int
     * @SWG\Property(description="The unique identifier of the software name.")
     */
    public $id;

    /**
     * @var string
     * @SWG\Property(type="string", maxLength=255, description="The name of the software.")
     */
    public $name;
}