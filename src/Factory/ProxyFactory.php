<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 03.11.2018
 * Time: 15:18
 */

namespace App\Factory;

use App\Model\ProxyResponseModel;

class ProxyFactory extends AbstractResponseModel
{
    /**
     * @param $entity
     * @return ProxyResponseModel
     */
    protected function fetch($entity)
    {
        return new ProxyResponseModel($entity);
    }
}