<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 14:53
 */

namespace App\Factory;

use App\Model\UserResponseModel;

/**
 * Class UserFactory
 * @package App\Factory
 */
class UserFactory extends AbstractResponseModel
{
    /**
     * @param $entity
     * @return UserResponseModel
     */
    protected function fetch($entity)
    {
        return new UserResponseModel($entity);
    }
}