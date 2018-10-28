<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 20:09
 */

namespace App\Interfaces;

use App\Adapter\UserAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface IUserService
 * @package App\Interfaces
 */
interface IUserService
{
    /**
     * @param IUser $user
     * @return JsonResponse
     */
    public function verify(IUser $user);

    /**
     * @param IUser $user
     * @return UserAdapter
     */
    public function mapUserCredentials(IUser $user);
}
