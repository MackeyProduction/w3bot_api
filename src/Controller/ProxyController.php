<?php

namespace App\Controller;

use App\Entity\Proxy;
use App\Factory\ProxyFactory;
use App\Factory\UProxyFactory;
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
     * @param ICollectionService $collectionService
     * @param IResponseService $responseService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchProxies(ICollectionService $collectionService, IResponseService $responseService)
    {
        $data = $this->getDoctrine()->getRepository(Proxy::class)->findAll();
        $result = $collectionService->getCollection(ProxyFactory::class, $data);

        return $responseService->getJsonResponse(QueryFetchedSuccessResponse::class, [ 'data' => $result ]);
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
     * @param ICollectionService $collectionService
     * @param IResponseService $responseService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchProxyById($id, ICollectionService $collectionService, IResponseService $responseService)
    {
        $data = $this->getDoctrine()->getRepository(Proxy::class)->findBy(['id' => $id]);
        $result = $collectionService->getCollection(ProxyFactory::class, $data);

        return $responseService->getJsonResponse(QueryFetchedSuccessResponse::class, [ 'data' => $result ]);
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
     * @param ITokenService $tokenService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postProxy(Request $request, ITokenService $tokenService)
    {
        if ($tokenService->getTokenResponse($request)->isSuccessful())
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

                    return $tokenService->getTokenResponse($request, ProxySuccessResponse::class);
                } else {
                    return $tokenService->getTokenResponse($request, ProxyExistsResponse::class);
                }
            } else {
                return $tokenService->getTokenResponse($request, ProxyFailedResponse::class);
            }
        }

        return $tokenService->getTokenResponse($request);
    }
}
