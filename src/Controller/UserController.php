<?php

namespace App\Controller;

use App\Model\UserResponseModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class UserController extends Controller
{
    /**
     * @Route("/api/user", methods={"GET"}, name="user")
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of proxies filtered by user.",
     *     @Model(type=UserResponseModel::class, groups={"non-sensitive-data"})
     * )
     * @SWG\Parameter(
     *     name="token",
     *     in="query",
     *     type="string",
     *     description="The token from the user.",
     *     required=true
     * )
     * @SWG\Tag(name="user")
     */
    public function fetchUser()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
