<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 14:47
 */

namespace App\Service;

use App\Adapter\UserAdapter;
use App\Entity\User;
use App\Interfaces\IResponseService;
use App\Interfaces\IUser;
use App\Interfaces\IUserService;
use App\Response\UserLoginFailedResponse;
use App\Response\UserLoginSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserService
 * @package App\Service
 */
class UserService implements IUserService
{
    /**
     * @var IResponseService
     */
    private $response;

    /**
     * UserService constructor.
     * @param IResponseService $response
     */
    public function __construct(IResponseService $response)
    {
        $this->response = $response;
    }

    /**
     * @param IUser $user
     * @return JsonResponse
     */
    public function verify(IUser $user)
    {
        /** @var $user User */
        if ($user != null) {
            $dbPassword = $user->getPassword();

            // is password valid?
            if (password_verify($user->getPlainPassword(), $dbPassword)) {
                return $this->response->getJsonResponse(UserLoginSuccessResponse::class);
            } else {
                return $this->response->getJsonResponse(UserLoginFailedResponse::class);
            }
        }

        return $this->response->getJsonResponse(UserLoginFailedResponse::class);
    }

    /**
     * Maps the IUser interface on UserInterface.
     * @param IUser $user
     * @return UserAdapter
     */
    public function mapUserCredentials(IUser $user)
    {
        return UserAdapter::create($user);
    }
}