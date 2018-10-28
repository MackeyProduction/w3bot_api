<?php

namespace App\Controller;

use App\Entity\UP;
use App\Factory\ProxyFactory;
use App\Interfaces\ICollectionService;
use App\Model\ProxyResponseModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class ProxyController extends AbstractController
{
    /**
     * Gets a list of proxies filtered by user.
     *
     * @Route("/api/proxy", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of proxies filtered by user.",
     *     @Model(type=ProxyResponseModel::class, groups={"full"})
     * )
     * @SWG\Parameter(
     *     name="token",
     *     in="query",
     *     type="string",
     *     description="The token from the user.",
     *     required=true
     * )
     * @SWG\Tag(name="proxy")
     *
     * @param ICollectionService $collectionService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchProxies(ICollectionService $collectionService)
    {
        $data = $this->getDoctrine()->getRepository(UP::class)->findAll();
        $result = $collectionService->getCollection(ProxyFactory::class, $data);

        return $this->json($result);
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
     * @SWG\Parameter(
     *     name="token",
     *     in="query",
     *     type="string",
     *     description="The token from the user.",
     *     required=true
     * )
     * @SWG\Tag(name="proxy")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postProxy()
    {
        return $this->json("");
    }
}
