<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 18:34
 */

namespace App\Collection;

use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Class SimpleCollection
 * @package App\Collection
 */
class SimpleCollection
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var ArrayAdapter
     */
    private $adapter;

    /**
     * SimpleCollection constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->adapter = new ArrayAdapter($data);
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
    public function getCollection()
    {
        return [
            'count' => $this->adapter->getNbResults(),
            'items' => $this->adapter->getArray()
        ];
    }

    /**
     * @return ArrayAdapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
}
