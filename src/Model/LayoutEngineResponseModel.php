<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 12.11.2018
 * Time: 16:45
 */

namespace App\Model;

use App\Entity\LayoutEngine;

/**
 * Class LayoutEngineResponseModel
 * @package App\Model
 */
class LayoutEngineResponseModel
{
    /**
     * LayoutEngineResponseModel constructor.
     * @param LayoutEngine $layoutEngine
     */
    public function __construct(LayoutEngine $layoutEngine)
    {
        $this->id = $layoutEngine->getId();
        $this->name = $layoutEngine->getName();
    }

    /**
     * @param LayoutEngine $layoutEngine
     * @return static
     */
    public static function create(LayoutEngine $layoutEngine)
    {
        return new static($layoutEngine);
    }

    /**
     * @var int
     * @SWG\Property(description="The unique identifier of the layout engine.")
     */
    public $id;

    /**
     * @var string
     * @SWG\Property(type="string", maxLength=255, description="The name of the layout engine.")
     */
    public $name;
}