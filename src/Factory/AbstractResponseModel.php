<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 14:48
 */

namespace App\Factory;

/**
 * Class AbstractResponseModel
 * @package App\Factory
 */
abstract class AbstractResponseModel
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $newArray = [];

    /**
     * AbstractResponseModel constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     * @return static
     */
    public static function create(array $data)
    {
        return new static($data);
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        foreach ($this->data as $item)
        {
            array_push($this->newArray, $this->fetch($item));
        }

        return $this->newArray;
    }

    protected abstract function fetch($entity);
}
