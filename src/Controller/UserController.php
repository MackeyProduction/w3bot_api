<?php

namespace App\Controller;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Interfaces\ICollectionService;
use App\Interfaces\ITokenService;
use App\Model\UserResponseModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
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
     * @SWG\Tag(name="user")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param ICollectionService $collectionService
     * @param ITokenService $tokenService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchUser(Request $request, ICollectionService $collectionService, ITokenService $tokenService)
    {
        $data = $this->getDoctrine()->getRepository(User::class)->findBy(['username' => $tokenService->getPayload($request)['username']]);
        $result = $collectionService->getCollection(UserFactory::class, $data);

        return $this->json($result);
    }
}
