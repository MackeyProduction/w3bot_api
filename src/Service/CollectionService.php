<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 14:47
 */

namespace App\Service;

use App\Collection\SimpleCollection;
use App\Factory\AbstractResponseModel;
use App\Interfaces\ICollectionService;

/**
 * Class CollectionService
 * @package App\Service
 */
class CollectionService implements ICollectionService
{
    public function __construct()
    {
    }

    /**
     * @param string $factory
     * @param array $data
     * @return array|null|static
     */
    public function getCollection(string $factory, array $data)
    {
        if (class_exists($factory)) {
            /** @var AbstractResponseModel $factory */
            $model = $factory::create($data);
            $result = SimpleCollection::create($model->getResponse());

            return $result->getCollection();
        }

        return null;
    }
}