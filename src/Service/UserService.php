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
     * @return boolean
     */
    public function verify(IUser $user)
    {
        /** @var $user User */
        if ($user != null) {
            $dbPassword = $user->getPassword();

            // is password valid?
            if (password_verify($user->getPlainPassword(), $dbPassword)) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    /**
     * @param IUser $user
     * @return bool
     */
    public function recoverPassword(IUser $user)
    {
        /** @var $user User */
        if ($user != null) {
            $username = $user->getUsername();
            $url = "";
            $text = "Dear ${$username},\n\n
                we got your request for recovering your password.\n
                Please visit the website to recover your password.\n
                \n{$url}
                \n\nYours sincerely,\n
                w3bot";
            $emailSend = mail($user->getEmail(), "Password recovering", $text);

            if ($emailSend) {
                return true;
            }
        }

        return false;
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