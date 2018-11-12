<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 12.11.2018
 * Time: 16:45
 */

namespace App\Model;

use App\Interfaces\ILayoutEngine;

/**
 * Class LayoutEngineResponseModel
 * @package App\Model
 */
class LayoutEngineResponseModel
{
    /**
     * LayoutEngineResponseModel constructor.
     * @param ILayoutEngine $layoutEngine
     */
    public function __construct(ILayoutEngine $layoutEngine)
    {
        $this->id = $layoutEngine->getId();
        $this->name = $layoutEngine->getName();
    }

    /**
     * @param ILayoutEngine $layoutEngine
     * @return static
     */
    public static function create(ILayoutEngine $layoutEngine)
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