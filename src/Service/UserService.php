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
use Symfony\Component\Config\Definition\Exception\Exception;
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
     * @param \Swift_Mailer $mailer
     * @return bool
     */
    public function recoverPassword(IUser $user, \Swift_Mailer $mailer)
    {
        /** @var $user User */
        if ($user != null) {
            $username = $user->getUsername();
            $url = "https://w3bot.org/recover/" . bin2hex(openssl_random_pseudo_bytes(20));
            $text = "Hi ${username},\n
                You recently requested to reset your password. Use the link below to reset it. This password reset is only valid for the next 24 hours.
                \n{$url}
                \nIf you did not request a password reset, please ignore this email or contact support if you have questions.
                \n\nThanks,\n
                Your w3bot Team";
            $message = (new \Swift_Message("Password recovery"))
                ->setFrom("support@w3bot.org")
                ->setTo($user->getEmail())
                ->setBody($text);

            $emailSend = $mailer->send($message);

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