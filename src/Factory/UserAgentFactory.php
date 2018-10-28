<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 14:54
 */

namespace App\Factory;

use App\Interfaces\IUUserAgent;
use App\Model\UserAgentResponseModel;

class UserAgentFactory extends AbstractResponseModel
{
    /**
     * @param IUUserAgent $entity
     * @return UserAgentResponseModel
     */
    protected function fetch($entity)
    {
        return new UserAgentResponseModel($entity);
    }
}