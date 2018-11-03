<?php

namespace App\Controller;

use App\Entity\Proxy;
use App\Entity\UP;
use App\Factory\ProxyFactory;
use App\Factory\UProxyFactory;
use App\Interfaces\ICollectionService;
use App\Interfaces\ITokenService;
use App\Model\ProxyResponseModel;
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchProxies(ICollectionService $collectionService)
    {
        $data = $this->getDoctrine()->getRepository(Proxy::class)->findAll();
        $result = $collectionService->getCollection(ProxyFactory::class, $data);

        return $this->json($result);
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
        $data = ProxyFactory::create($this->getDoctrine()->getRepository(Proxy::class)->findBy(['id' => $id]))->getResponse();

        return $this->json($data);
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postProxy()
    {
        return $this->json("");
    }
}
