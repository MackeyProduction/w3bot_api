<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 12.11.2018
 * Time: 16:29
 */

namespace App\Model;

use App\Entity\SoftwareName;
use App\Interfaces\ILayoutEngine;
use App\Interfaces\ISoftware;
use App\Interfaces\ISoftwareName;

/**
 * Class SoftwareResponseModel
 * @package App\Model
 */
class SoftwareResponseModel
{
    /**
     * SoftwareResponseModel constructor.
     * @param ISoftware $software
     */
    public function __construct(ISoftware $software)
    {
        $this->id = $software->getId();
        $this->softwareName = SoftwareNameResponseModel::create($software->getSoftwareName());
        $this->version = $software->getVersion();
        $this->layoutEngine = LayoutEngineResponseModel::create($software->getLayoutEngine());
        $this->leVersion = $software->getLeVersion();
    }

    /**
     * @param ISoftware $software
     * @return static
     */
    public static function create(ISoftware $software)
    {
        return new static($software);
    }

    /**
     * @var int
     * @SWG\Property(description="The unique identifier of the proxy.")
     */
    public $id;

    /**
     * @var ISoftwareName
     */
    public $softwareName;

    /**
     * @var string
     * @SWG\Property(type="string", maxLength=255, description="The version of the software.")
     */
    public $version;

    /**
     * @var ILayoutEngine
     */
    public $layoutEngine;

    /**
     * @var string
     * @SWG\Property(type="string", maxLength=255, description="The layout engine version of the software.")
     */
    public $leVersion;
}