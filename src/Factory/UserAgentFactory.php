<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 03.11.2018
 * Time: 15:18
 */

namespace App\Factory;

use App\Model\UserAgentResponseModel;

/**
 * Class UserAgentFactory
 * @package App\Factory
 */
class UserAgentFactory extends AbstractResponseModel
{
    /**
     * @param $entity
     * @return UserAgentResponseModel
     */
    protected function fetch($entity)
    {
        return new UserAgentResponseModel($entity);
    }
}