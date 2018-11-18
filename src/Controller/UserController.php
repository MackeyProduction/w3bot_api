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
        if ($tokenService->getTokenResponse($request)->isSuccessful())
        {
            $data = $this->getDoctrine()->getRepository(User::class)->findAll();
            $result = $collectionService->getCollection(UserFactory::class, $data);

            return $tokenService->getTokenResponse($request, QueryFetchedSuccessResponse::class, $result);
        }

        return $tokenService->getTokenResponse($request);
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
     * @param ICollectionService $collectionService
     * @param ITokenService $tokenService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchUserAgents(Request $request, ICollectionService $collectionService, ITokenService $tokenService)
    {
        if ($tokenService->getTokenResponse($request)->isSuccessful())
        {
            /** @var User $data */
            $data = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $tokenService->getPayload($request)['username']]);
            $result = $collectionService->getCollection(UserAgentFactory::class, $data->getUua()->toArray());

            return $tokenService->getTokenResponse($request, QueryFetchedSuccessResponse::class, $result);
        }

        return $tokenService->getTokenResponse($request);
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
     * @param ITokenService $tokenService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postUserAgent(Request $request, ITokenService $tokenService)
    {
        if ($tokenService->getTokenResponse($request)->isSuccessful())
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

                        return $tokenService->getTokenResponse($request, UserAgentSuccessResponse::class);
                    } else {
                        return $tokenService->getTokenResponse($request, UserAgentExistsResponse::class);
                    }
                } else {
                    return $tokenService->getTokenResponse($request, QueryNotExistResponse::class);
                }
            } else {
                return $tokenService->getTokenResponse($request, UserAgentFailedResponse::class);
            }
        }

        return $tokenService->getTokenResponse($request);
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
     * @param ICollectionService $collectionService
     * @param ITokenService $tokenService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchProxies(Request $request, ICollectionService $collectionService, ITokenService $tokenService)
    {
        if ($tokenService->getTokenResponse($request)->isSuccessful())
        {
            /** @var User $data */
            $data = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $tokenService->getPayload($request)['username']]);
            $result = $collectionService->getCollection(ProxyFactory::class, $data->getUp()->toArray());

            return $tokenService->getTokenResponse($request, QueryFetchedSuccessResponse::class, $result);
        }

        return $tokenService->getTokenResponse($request);
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
     * @param ITokenService $tokenService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postProxy(Request $request, ITokenService $tokenService)
    {
        if ($tokenService->getTokenResponse($request)->isSuccessful())
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

                        return $tokenService->getTokenResponse($request, ProxySuccessResponse::class);
                    } else {
                        return $tokenService->getTokenResponse($request, ProxyExistsResponse::class);
                    }
                }
            } else {
                return $tokenService->getTokenResponse($request, ProxyFailedResponse::class);
            }
        }

        return $tokenService->getTokenResponse($request);
    }
}
