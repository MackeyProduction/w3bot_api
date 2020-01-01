<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 20:09
 */

namespace App\Interfaces;

use App\Adapter\UserAdapter;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface IUserService
 * @package App\Interfaces
 */
interface IUserService
{
    /**
     * @param User $user
     * @return JsonResponse
     */
    public function verify(User $user);

    /**
     * @param User $user
     * @return UserAdapter
     */
    public function mapUserCredentials(User $user);

    /**
     * @param User $user
     * @param \Swift_Mailer $mailer
     * @return bool
     */
    public function recoverPassword(User $user, \Swift_Mailer $mailer);
}
