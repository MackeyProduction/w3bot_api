<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 12.11.2018
 * Time: 16:29
 */

namespace App\Model;

use App\Entity\LayoutEngine;
use App\Entity\Software;
use App\Entity\SoftwareName;

/**
 * Class SoftwareResponseModel
 * @package App\Model
 */
class SoftwareResponseModel
{
    /**
     * SoftwareResponseModel constructor.
     * @param Software $software
     */
    public function __construct(Software $software)
    {
        $this->id = $software->getId();
        $this->softwareName = SoftwareNameResponseModel::create($software->getSoftwareName());
        $this->version = $software->getVersion();
        $this->layoutEngine = LayoutEngineResponseModel::create($software->getLayoutEngine());
        $this->leVersion = $software->getLeVersion();
    }

    /**
     * @param Software $software
     * @return static
     */
    public static function create(Software $software)
    {
        return new static($software);
    }

    /**
     * @var int
     * @SWG\Property(description="The unique identifier of the proxy.")
     */
    public $id;

    /**
     * @var SoftwareName
     */
    public $softwareName;

    /**
     * @var string
     * @SWG\Property(type="string", maxLength=255, description="The version of the software.")
     */
    public $version;

    /**
     * @var LayoutEngine
     */
    public $layoutEngine;

    /**
     * @var string
     * @SWG\Property(type="string", maxLength=255, description="The layout engine version of the software.")
     */
    public $leVersion;
}