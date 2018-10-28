<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 14:54
 */

namespace App\Factory;

use App\Interfaces\IUProxy;
use App\Model\ProxyResponseModel;

class ProxyFactory extends AbstractResponseModel
{
    /**
     * @param IUProxy $entity
     * @return ProxyResponseModel
     */
    protected function fetch($entity)
    {
        return new ProxyResponseModel($entity);
    }
}