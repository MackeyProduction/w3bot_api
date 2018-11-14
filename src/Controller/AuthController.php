<?php

namespace App\Controller;

use App\Entity\Rank;
use App\Entity\User;
use App\Interfaces\IResponseService;
use App\Interfaces\ITokenService;
use App\Interfaces\IUser;
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
use App\Service\TokenService;
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
     *     name="username",
     *     in="header",
     *     type="string",
     *     description="The username from the user.",
     *     required=true
     * )
     * @SWG\Parameter(
     *     name="password",
     *     in="header",
     *     type="string",
     *     description="The password from the user.",
     *     required=true
     * )
     * @SWG\Tag(name="auth")
     *
     * @param Request $request
     * @param JWTTokenManagerInterface $JWTTokenManager
     * @param IUserService $userService
     * @param IResponseService $response
     * @return JsonResponse
     */
    public function loginAction(Request $request, JWTTokenManagerInterface $JWTTokenManager, IUserService $userService, IResponseService $response)
    {
        // fetch credentials
        $username = $request->headers->get("username");
        $plainPassword = $request->headers->get("password");

        // fetch username
        $result = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $username]);

        if ($result != null) {
            $result->setPlainPassword($plainPassword);

            /** @var IUser $result */
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
        return $tokenService->getTokenResponse($request, ['response' => 'User logged out successfully.']);
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
     * Refresh an expired token from a user.
     *
     * @Route("/api/forgot", methods={"POST"}, name="refresh")
     * @SWG\Response(
     *     response=200,
     *     description="The token refreshed successfully.",
     * )
     * @SWG\Response(
     *     response=403,
     *     description="The token refresh failed.",
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
     * @param ITokenService $tokenService
     * @return JsonResponse
     */
    public function forgotPasswordAction(Request $request, IResponseService $responseService, IUserService $userService, ITokenService $tokenService)
    {
        $email = $request->request->get("email");

        if (empty($email)) {
            return $responseService->getJsonResponse(ForgotPasswordFailedResponse::class);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($user != null) {
            return $responseService->getJsonResponse(ForgotPasswordFailedResponse::class);
        }

        /** @var IUser $user*/
        $response = $userService->recoverPassword($user);

        if (!$response) {
            return $responseService->getJsonResponse(ForgotPasswordFailedResponse::class);
        }

        return $responseService->getJsonResponse(ForgotPasswordSuccessResponse::class);
    }
}
