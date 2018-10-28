<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 16:52
 */

namespace App\Interfaces;

use App\Collection\SimpleCollection;

/**
 * Interface ICollectionService
 * @package App\Interfaces
 */
interface ICollectionService
{
    /**
     * @param string $factory
     * @param array $data
     * @return array
     */
    public function getCollection(string $factory, array $data);
}