<?php

namespace App\Controller;

use App\Entity\Proxy;
use App\Entity\User;
use App\Entity\UserAgent;
use App\Factory\UserAgentFactory;
use App\Factory\UserFactory;
use App\Interfaces\ICollectionService;
use App\Interfaces\ITokenService;
use App\Model\UserResponseModel;
use App\Model\UserAgentResponseModel;
use App\Model\ProxyResponseModel;
use App\Response\ProxyExistsResponse;
use App\Response\ProxyFailedResponse;
use App\Response\ProxySuccessResponse;
use App\Response\QueryFetchedSuccessResponse;
use App\Response\QueryNotExistResponse;
use App\Response\UserAgentExistsResponse;
use App\Response\UserAgentFailedResponse;
use App\Response\UserAgentSuccessResponse;
use App\Factory\ProxyFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class UserController extends Controller
{
    /**
     * @var ITokenService $tokenService
     */
    private $tokenService;

    /**
     * @var ICollectionService $collectionService
     */
    private $collectionService;

    public function __construct(ITokenService $tokenService, ICollectionService $collectionService)
    {
        $this->tokenService = $tokenService;
        $this->collectionService = $collectionService;
    }

    /**
     * @Route("/api/user", methods={"GET"}, name="user")
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of proxies filtered by user.",
     *     @Model(type=UserResponseModel::class, groups={"non-sensitive-data"})
     * )
     * @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     type="string",
     *     description="The field used for username."
     * )
     * @SWG\Tag(name="user")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchUser(Request $request)
    {
        if ($this->tokenService->getTokenResponse($request)->isSuccessful())
        {
            $data = $this->getDoctrine()->getRepository(User::class)->findAll();

            if (!empty($request->query->get("name"))) {
                $data = $this->getDoctrine()->getRepository(User::class)->findBy([ 'username' => $request->query->get("name") ]);
            }

            $result = $this->collectionService->getCollection(UserFactory::class, $data);

            return $this->tokenService->getTokenResponse($request, QueryFetchedSuccessResponse::class, $result);
        }

        return $this->tokenService->getTokenResponse($request);
    }

    /**
     * Gets a list of user agents from the user.
     *
     * @Route("/api/user/agent", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of user agent filtered by user.",
     *     @Model(type=UserAgentResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="user")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchUserAgents(Request $request)
    {
        if ($this->tokenService->getTokenResponse($request)->isSuccessful())
        {
            /** @var User $data */
            $data = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $this->tokenService->getPayload($request)['username']]);
            $result = $this->collectionService->getCollection(UserAgentFactory::class, $data->getUua()->toArray());

            return $this->tokenService->getTokenResponse($request, QueryFetchedSuccessResponse::class, $result);
        }

        return $this->tokenService->getTokenResponse($request);
    }

    /**
     * Inserts a new user agent to the database.
     *
     * @Route("/api/user/agent", methods={"POST"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns true when insert was successful.",
     *     @Model(type=UserAgentResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="user")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postUserAgent(Request $request)
    {
        if ($this->tokenService->getTokenResponse($request)->isSuccessful())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $userId = $request->request->get("userId");
            $userAgentId = $request->request->get("userAgentId");

            if ($userId != "" && $userAgentId != "") {
                $userResult = $this->getDoctrine()->getRepository(User::class)->find($userId);
                $userAgentResult = $this->getDoctrine()->getRepository(UserAgent::class)->find($userAgentId);

                if ($userResult != null && $userAgentResult != null) {
                    $uuaResult = $this->getDoctrine()->getRepository(User::class)->findOneByUserIdAndUserAgentId($userId, $userAgentId);

                    if ($uuaResult == null) {
                        /** @var UserAgent $userAgentResult */
                        $userResult->addUua($userAgentResult);

                        $entityManager->persist($userResult);
                        $entityManager->flush();

                        return $this->tokenService->getTokenResponse($request, UserAgentSuccessResponse::class);
                    } else {
                        return $this->tokenService->getTokenResponse($request, UserAgentExistsResponse::class);
                    }
                } else {
                    return $this->tokenService->getTokenResponse($request, QueryNotExistResponse::class);
                }
            } else {
                return $this->tokenService->getTokenResponse($request, UserAgentFailedResponse::class);
            }
        }

        return $this->tokenService->getTokenResponse($request);
    }

    /**
     * Gets a list of proxies filtered by user.
     *
     * @Route("/api/user/proxy", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of proxies filtered by user.",
     *     @Model(type=ProxyResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="user")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchProxies(Request $request)
    {
        if ($this->tokenService->getTokenResponse($request)->isSuccessful())
        {
            /** @var User $data */
            $data = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $this->tokenService->getPayload($request)['username']]);
            $result = $this->collectionService->getCollection(ProxyFactory::class, $data->getUp()->toArray());

            return $this->tokenService->getTokenResponse($request, QueryFetchedSuccessResponse::class, $result);
        }

        return $this->tokenService->getTokenResponse($request);
    }

    /**
     * Inserts a new proxy into the database.
     *
     * @Route("/api/user/proxy", methods={"POST"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns true when insert was successful.",
     *     @Model(type=ProxyResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="user")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postProxy(Request $request)
    {
        if ($this->tokenService->getTokenResponse($request)->isSuccessful())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $userId = $request->request->get("userId");
            $proxyId = $request->request->get("proxyId");

            if ($userId != "" && $proxyId != "") {
                $userResult = $this->getDoctrine()->getRepository(User::class)->find($userId);
                $proxyResult = $this->getDoctrine()->getRepository(Proxy::class)->find($proxyId);

                if ($userResult != null && $proxyResult != null) {
                    $upResult = $this->getDoctrine()->getRepository(User::class)->findOneByUserIdAndProxyId($userId, $proxyId);

                    if ($upResult == null) {
                        /** @var Proxy $proxyResult*/
                        $userResult->addUp($proxyResult);

                        $entityManager->persist($userResult);
                        $entityManager->flush();

                        return $this->tokenService->getTokenResponse($request, ProxySuccessResponse::class);
                    } else {
                        return $this->tokenService->getTokenResponse($request, ProxyExistsResponse::class);
                    }
                }
            } else {
                return $this->tokenService->getTokenResponse($request, ProxyFailedResponse::class);
            }
        }

        return $this->tokenService->getTokenResponse($request);
    }
}
