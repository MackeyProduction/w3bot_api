<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 25.10.2018
 * Time: 20:55
 */

namespace App\Controller;

use App\Entity\UUA;
use App\Factory\UserAgentFactory;
use App\Interfaces\ICollectionService;
use App\Model\UserAgentResponseModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class UserAgentController extends Controller
{
    /**
     * Gets a list of user agents from the user.
     *
     * @Route("/api/agent", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of user agent from the user.",
     *     @Model(type=UserAgentResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="agent")
     * @Security(name="Bearer")
     *
     * @param ICollectionService $collectionService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchUserAgents(ICollectionService $collectionService)
    {
        $data = $this->getDoctrine()->getRepository(UUA::class)->findAll();
        $result = $collectionService->getCollection(UserAgentFactory::class, $data);

        return $this->json($result);
    }

    /**
     * Inserts a new user agent to the database.
     *
     * @Route("/api/agent", methods={"POST"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns true when insert was successful.",
     *     @Model(type=UserAgentResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="agent")
     * @Security(name="Bearer")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postUserAgent()
    {
        return $this->json("");
    }
}