<?php

namespace App\Controller;

use App\Entity\User;
use App\Interfaces\IUser;
use App\Interfaces\IUserService;
use App\Model\UserResponseModel;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\Model;
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
     * @return JsonResponse
     */
    public function loginAction(Request $request, JWTTokenManagerInterface $JWTTokenManager, IUserService $userService)
    {
        // fetch credentials
        $username = $request->headers->get("username");
        $plainPassword = $request->headers->get("password");
        $json = [];

        // fetch username
        $result = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $username]);
        $result->setPlainPassword($plainPassword);

        /** @var IUser $result */
        $response = $userService->verify($result);

        if ($response->isOk()) {
            $mappedUser = $userService->mapUserCredentials($result);

            // generate token
            $token = $JWTTokenManager->create($mappedUser);

            array_push($json, [ $response->getContent(), 'token' => $token ]);
        } else {
            array_push($json, [ $response->getContent() ]);
        }

        return $this->json($json);
    }

    /**
     * The user will be logged out.
     *
     * @Route("/api/logout", methods={"POST"}, name="logout")
     * @SWG\Response(
     *     response=200,
     *     description="The user logged out successfully.",
     * )
     * @SWG\Parameter(
     *     name="username",
     *     in="query",
     *     type="string",
     *     description="The username from the user.",
     *     required=true
     * )
     * @SWG\Parameter(
     *     name="token",
     *     in="query",
     *     type="string",
     *     description="The token from the user.",
     *     required=true
     * )
     * @SWG\Tag(name="auth")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function logoutAction(Request $request)
    {
        $username = $request->headers->get("username");
        $token = $request->headers->get("token");

        /** @var $result User */
        $result = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $username]);
        $user = new UserResponseModel($result);
        $authenticationSuccessHandler = $this->container->get('lexik_jwt_authentication.handler.authentication_success');

        return $this->json([
            'path' => 'src/Controller/UserController.php',
            'response' => $authenticationSuccessHandler->handleAuthenticationSuccess($user, $token),
        ]);
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
