<?php

namespace App\Controller;

use App\Entity\Proxy;
use App\Factory\ProxyFactory;
use App\Interfaces\ICollectionService;
use App\Interfaces\IResponseService;
use App\Interfaces\ITokenService;
use App\Model\ProxyResponseModel;
use App\Response\ProxyExistsResponse;
use App\Response\ProxyFailedResponse;
use App\Response\ProxySuccessResponse;
use App\Response\QueryFetchedSuccessResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class ProxyController extends AbstractController
{
    /**
     * @var ITokenService $tokenService
     */
    private $tokenService;

    /**
     * @var ICollectionService $collectionService
     */
    private $collectionService;

    /**
     * @var IResponseService $responseService
     */
    private $responseService;

    public function __construct(
        ITokenService $tokenService,
        ICollectionService $collectionService,
        IResponseService $responseService)
    {
        $this->tokenService = $tokenService;
        $this->collectionService = $collectionService;
        $this->responseService = $responseService;
    }

    /**
     * Gets a list of proxies filtered by user.
     *
     * @Route("/api/proxy", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of proxies.",
     *     @Model(type=ProxyResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="proxy")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchProxies()
    {
        $data = $this->getDoctrine()->getRepository(Proxy::class)->findAll();
        $result = $this->collectionService->getCollection(ProxyFactory::class, $data);

        return $this->responseService->getJsonResponse(QueryFetchedSuccessResponse::class, [ 'data' => $result ]);
    }

    /**
     * Gets a proxy by id
     *
     * @Route("/api/proxy/{id}", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a proxy by id.",
     *     @Model(type=ProxyResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="proxy")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchProxyById($id)
    {
        $data = $this->getDoctrine()->getRepository(Proxy::class)->findBy(['id' => $id]);
        $result = $this->collectionService->getCollection(ProxyFactory::class, $data);

        return $this->responseService->getJsonResponse(QueryFetchedSuccessResponse::class, [ 'data' => $result ]);
    }

    /**
     * Inserts a new proxy into the database.
     *
     * @Route("/api/proxy", methods={"POST"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns true when insert was successful.",
     *     @Model(type=ProxyResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="proxy")
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

            $ip = $request->request->get("ip");
            $port = $request->request->get("port");
            $name = $request->request->get("name");
            $username = $request->request->get("username");
            $password = $request->request->get("password");

            if ($ip != "" && $port != "" && $name != "") {
                $proxyResult = $this->getDoctrine()->getRepository(Proxy::class)->findOneBy(['name' => $name]);

                if ($proxyResult == null) {
                    $proxyEntity = new Proxy();
                    $proxyEntity->setIp($ip);
                    $proxyEntity->setPort($port);
                    $proxyEntity->setName($name);
                    $proxyEntity->setUsername($username);
                    $proxyEntity->setPassword($password);

                    $entityManager->persist($proxyEntity);
                    $entityManager->flush();

                    return $this->tokenService->getTokenResponse($request, ProxySuccessResponse::class);
                } else {
                    return $this->tokenService->getTokenResponse($request, ProxyExistsResponse::class);
                }
            } else {
                return $this->tokenService->getTokenResponse($request, ProxyFailedResponse::class);
            }
        }

        return $this->tokenService->getTokenResponse($request);
    }
}
