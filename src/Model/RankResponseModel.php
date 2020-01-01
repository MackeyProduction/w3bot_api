<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 12.11.2018
 * Time: 17:20
 */

namespace App\Model;

use App\Entity\Rank;

/**
 * Class RankResponseModel
 * @package App\Model
 */
class RankResponseModel
{
    /**
     * RankResponseModel constructor.
     * @param Rank $rank
     */
    public function __construct(Rank $rank)
    {
        $this->id = $rank->getId();
        $this->name = $rank->getName();
    }

    /**
     * @param Rank $rank
     * @return static
     */
    public static function create(Rank $rank)
    {
        return new static($rank);
    }

    /**
     * @var int
     * @SWG\Property(description="The unique identifier of the rank.")
     */
    public $id;

    /**
     * @var string
     * @SWG\Property(type="string", maxLength=255, description="The name of the rank.")
     */
    public $name;
}