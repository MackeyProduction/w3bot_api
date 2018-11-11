<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 14:54
 */

namespace App\Factory;

use App\Interfaces\IUser;
use App\Interfaces\IUUserAgent;
use App\Model\UUserAgentResponseModel;

class UUserAgentFactory extends AbstractResponseModel
{
    /**
     * @param IUser $entity
     * @return UUserAgentResponseModel
     */
    protected function fetch($entity)
    {
        return new UUserAgentResponseModel($entity);
    }
}