<?php

namespace App\Controller;

use App\Entity\Rank;
use App\Entity\User;
use App\Interfaces\IResponseService;
use App\Interfaces\ITokenService;
use App\Interfaces\IUserService;
use App\Model\UserResponseModel;
use App\Response\ForgotPasswordFailedResponse;
use App\Response\ForgotPasswordSuccessResponse;
use App\Response\QueryNotExistResponse;
use App\Response\RegisterFailedResponse;
use App\Response\RegisterSuccessResponse;
use App\Response\TokenRefreshFailedResponse;
use App\Response\UserLoginFailedResponse;
use App\Response\UserLoginSuccessResponse;
use App\Response\UserLogoutSuccessResponse;
use App\Service\TokenService;
use JMS\Serializer\SerializerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\HeaderAwareJWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthController extends Controller
{
    /**
     * The user will be logged in.
     *
     * @Route("/api/login", methods={"POST"}, name="login")
     * @SWG\Response(
     *     response=200,
     *     description="The user logged in successfully."
     * )
     * @SWG\Response(
     *     response=403,
     *     description="The user login was failed.",
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     type="string",
     *     description="The request body for user login. For a successful user login are username and password required.",
     *     required=true,
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"non_sensitive_data"}))
     *     )
     * )
     * @SWG\Tag(name="auth")
     *
     * @param Request $request
     * @param JWTTokenManagerInterface $JWTTokenManager
     * @param IUserService $userService
     * @param IResponseService $response
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function loginAction(Request $request, JWTTokenManagerInterface $JWTTokenManager, IUserService $userService, IResponseService $response, SerializerInterface $serializer)
    {
        // fetch credentials
        /** @var User $user */
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');

        // fetch username
        $result = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $user->getUsername()]);

        if ($result != null) {
            $result->setPlainPassword($user->getPassword());

            /** @var User $result */
            $isOk = $userService->verify($result);

            if ($isOk) {
                $mappedUser = $userService->mapUserCredentials($result);

                // generate token
                $token = $JWTTokenManager->create($mappedUser);

                return $response->getJsonResponse(UserLoginSuccessResponse::class, ['token' => $token]);
            }
        }

        return $response->getJsonResponse(UserLoginFailedResponse::class);
    }

    /**
     * The user will be logged out.
     *
     * @Route("/api/logout", methods={"POST"}, name="logout")
     * @SWG\Response(
     *     response=200,
     *     description="The user logged out successfully.",
     * )
     * @SWG\Tag(name="auth")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param ITokenService $tokenService
     * @return JsonResponse
     */
    public function logoutAction(Request $request, ITokenService $tokenService)
    {
        return $tokenService->getTokenResponse($request, UserLogoutSuccessResponse::class);
    }

    /**
     * Registers a new user.
     *
     * @Route("/api/register", methods={"POST"}, name="register")
     * @SWG\Response(
     *     response=200,
     *     description="The user registered successfully.",
     * )
     * @SWG\Response(
     *     response=403,
     *     description="The user registration was failed.",
     * )
     * @SWG\Parameter(
     *     name="username",
     *     in="query",
     *     type="string",
     *     description="The username from the user.",
     *     required=true
     * )
     * @SWG\Parameter(
     *     name="password",
     *     in="query",
     *     type="string",
     *     description="The password from the user.",
     *     required=true
     * )
     * @SWG\Parameter(
     *     name="email",
     *     in="query",
     *     type="string",
     *     description="The email from the user.",
     *     required=true
     * )
     * @SWG\Tag(name="auth")
     *
     * @param Request $request
     * @param IResponseService $responseService
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws \Exception
     */
    public function registerAction(Request $request, IResponseService $responseService, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $username = $request->request->get("username");
        $plainPassword = $request->request->get("password");
        $email = $request->request->get("email");

        if (empty($username) || empty($plainPassword) || empty($email)) {
            return $responseService->getJsonResponse(RegisterFailedResponse::class);
        }

        $user = new User();
        $user->setUsername($username);
        $user->setPlainPassword($plainPassword);
        $user->setPassword(password_hash($user->getPlainPassword(), PASSWORD_BCRYPT, ['cost' => 12]));
        $user->setEmail($email);
        $user->setRegisterDate(new \DateTime());

        /** @var Rank $rank */
        $rank = $entityManager->getRepository(Rank::class)->findOneBy(['name' => 'ROLE_FREE_USER']);

        // check if query exists
        if ($rank == null) {
            return $responseService->getJsonResponse(QueryNotExistResponse::class);
        }

        $user->setRank($rank);

        // catch errors
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $errorString = (string)$errors;

            return $responseService->getJsonResponse(RegisterFailedResponse::class, [ 'error' => $errorString ]);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return $responseService->getJsonResponse(RegisterSuccessResponse::class);
    }

    /**
     * Refresh an expired token from a user.
     *
     * @Route("/api/refresh", methods={"POST"}, name="refresh")
     * @SWG\Response(
     *     response=200,
     *     description="The token refreshed successfully.",
     * )
     * @SWG\Response(
     *     response=403,
     *     description="The token refresh failed.",
     * )
     * @SWG\Parameter(
     *     name="expiredToken",
     *     in="query",
     *     type="string",
     *     description="The expired token from the user.",
     *     required=true
     * )
     * @SWG\Tag(name="auth")
     *
     * @param Request $request
     * @param IResponseService $responseService
     * @param IUserService $userService
     * @param ITokenService $tokenService
     * @return JsonResponse
     */
    public function refreshTokenAction(Request $request, IResponseService $responseService, IUserService $userService, ITokenService $tokenService)
    {
        $expiredToken = $request->request->get("expiredToken");

        if (empty($expiredToken)) {
            return $responseService->getJsonResponse(TokenRefreshFailedResponse::class);
        }

        $response = $tokenService->refreshToken($expiredToken, $userService);

        return $response;
    }

    /**
     * Password recovery for a user.
     *
     * @Route("/api/forgot", methods={"POST"}, name="forgot")
     * @SWG\Response(
     *     response=200,
     *     description="The password recovery was successful.",
     * )
     * @SWG\Response(
     *     response=403,
     *     description="The password recovery failed.",
     * )
     * @SWG\Parameter(
     *     name="email",
     *     in="query",
     *     type="string",
     *     description="The email address of the user.",
     *     required=true
     * )
     * @SWG\Tag(name="auth")
     *
     * @param Request $request
     * @param IResponseService $responseService
     * @param IUserService $userService
     * @param \Swift_Mailer $mailer
     * @return JsonResponse
     */
    public function forgotPasswordAction(Request $request, IResponseService $responseService, IUserService $userService, \Swift_Mailer $mailer)
    {
        $username = $request->request->get("username");

        if (!empty($username)) {
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $username]);

            // check if user exists
            if ($user == null) {
                return $responseService->getJsonResponse(QueryNotExistResponse::class);
            }

            /** @var User $user*/
            $response = $userService->recoverPassword($user, $mailer);

            // email send successfully?
            if (!$response) {
                return $responseService->getJsonResponse(ForgotPasswordFailedResponse::class);
            }

            return $responseService->getJsonResponse(ForgotPasswordSuccessResponse::class);
        }

        return $responseService->getJsonResponse(ForgotPasswordFailedResponse::class);
    }

    /**
     * The user gets the current status of the user token.
     *
     * @Route("/api/status", methods={"POST"}, name="status")
     * @SWG\Response(
     *     response=200,
     *     description="The user token is valid.",
     * )
     * @SWG\Response(
     *     response=400,
     *     description="The authorization header isn't set or is invalid.",
     * )
     * @SWG\Response(
     *     response=403,
     *     description="The user token isn't valid anymore.",
     * )
     * @SWG\Tag(name="auth")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param ITokenService $tokenService
     * @return JsonResponse
     */
    public function statusAction(Request $request, ITokenService $tokenService)
    {
        return $tokenService->getTokenResponse($request);
    }
}
