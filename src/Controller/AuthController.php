<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
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
     *     description="The user logged in successfully.",
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $username = $request->query->get("username");
        $plainPassword = $request->query->get("password");
        $json = [ 'path' => 'src/Controller/UserController.php' ];
        $response = new Response();
        $response->headers->set("Content-Type", "application/json");

        // fetch username
        $result = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $username]);

        /** @var $result User */
        if ($result != null) {
            $userPassword = password_hash($plainPassword, PASSWORD_BCRYPT);
            $dbPassword = $result->getPassword();

            if ($userPassword == $dbPassword) {
                // generate random session id
                $sessionId = bin2hex(openssl_random_pseudo_bytes(10));

                array_push($json, [ 'response' => 'User logged in successfully.', 'sessionId' => $sessionId ]);
                $response->setStatusCode(Response::HTTP_OK);
            } else {
                array_push($json, [ 'response' => 'User login failed. Wrong username or password.' ]);
                $response->setStatusCode(Response::HTTP_FORBIDDEN);
            }
        } else {
            array_push($json, [ 'response' => 'User login failed.' ]);
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
        }

        // set content of response
        $response->setContent(json_encode($json));

        return $response->prepare($request);
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
     *     name="sessionId",
     *     in="query",
     *     type="string",
     *     description="The session id.",
     *     required=true
     * )
     * @SWG\Tag(name="auth")
     */
    public function logoutAction()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
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
