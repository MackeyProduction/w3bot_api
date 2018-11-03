<?php

namespace App\Controller;

use App\Entity\User;
use App\Interfaces\IResponseService;
use App\Interfaces\ITokenService;
use App\Interfaces\IUser;
use App\Interfaces\IUserService;
use App\Model\UserResponseModel;
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
     */
    public function registerAction()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }
}
