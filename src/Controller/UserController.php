<?php

namespace App\Controller;

use App\Entity\UP;
use App\Entity\User;
use App\Entity\UUA;
use App\Factory\UProxyFactory;
use App\Factory\UUserAgentFactory;
use App\Factory\UserFactory;
use App\Interfaces\ICollectionService;
use App\Interfaces\ITokenService;
use App\Model\UserResponseModel;
use App\Model\UUserAgentResponseModel;
use App\Model\UProxyResponseModel;
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

        return $tokenService->getTokenResponse($request, [ 'data' => $result ]);
    }

    /**
     * Gets a list of user agents from the user.
     *
     * @Route("/api/user/agent", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of user agent filtered by user.",
     *     @Model(type=UUserAgentResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="user")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param ICollectionService $collectionService
     * @param ITokenService $tokenService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchUserAgents(Request $request, ICollectionService $collectionService, ITokenService $tokenService)
    {
        $data = $this->getDoctrine()->getRepository(UUA::class)->findBy(['username' => $tokenService->getPayload($request)['username']]);
        $result = $collectionService->getCollection(UUserAgentFactory::class, $data);

        return $this->json($result);
    }

    /**
     * Inserts a new user agent to the database.
     *
     * @Route("/api/user/agent", methods={"POST"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns true when insert was successful.",
     *     @Model(type=UUserAgentResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="user")
     * @Security(name="Bearer")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postUserAgent()
    {
        return $this->json("");
    }

    /**
     * Gets a list of proxies filtered by user.
     *
     * @Route("/api/user/proxy", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of proxies filtered by user.",
     *     @Model(type=UProxyResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="user")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param ICollectionService $collectionService
     * @param ITokenService $tokenService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchProxies(Request $request, ICollectionService $collectionService, ITokenService $tokenService)
    {
        $data = $this->getDoctrine()->getRepository(UP::class)->findBy(['username' => $tokenService->getPayload($request)['username']]);
        $result = $collectionService->getCollection(UProxyFactory::class, $data);

        return $this->json($result);
    }

    /**
     * Inserts a new proxy into the database.
     *
     * @Route("/api/user/proxy", methods={"POST"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns true when insert was successful.",
     *     @Model(type=UProxyResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="user")
     * @Security(name="Bearer")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postProxy()
    {
        return $this->json("");
    }
}
