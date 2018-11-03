<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 14:54
 */

namespace App\Factory;

use App\Interfaces\IUProxy;
use App\Model\UProxyResponseModel;

class UProxyFactory extends AbstractResponseModel
{
    /**
     * @param IUProxy $entity
     * @return UProxyResponseModel
     */
    protected function fetch($entity)
    {
        return new UProxyResponseModel($entity);
    }
}