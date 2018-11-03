<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 25.10.2018
 * Time: 20:55
 */

namespace App\Controller;

use App\Entity\UserAgent;
use App\Entity\UUA;
use App\Factory\UserAgentFactory;
use App\Factory\UUserAgentFactory;
use App\Interfaces\ICollectionService;
use App\Interfaces\ITokenService;
use App\Model\UserAgentResponseModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserAgentController extends Controller
{
    /**
     * Gets a list of user agents from the user.
     *
     * @Route("/api/agent", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of user agents.",
     *     @Model(type=UserAgentResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="agent")
     *
     * @param ICollectionService $collectionService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchUserAgents(ICollectionService $collectionService)
    {
        $data = $this->getDoctrine()->getRepository(UserAgent::class)->findAll();
        $result = $collectionService->getCollection(UserAgentFactory::class, $data);

        return $this->json($result);
    }

    /**
     * Gets a user agent by id.
     *
     * @Route("/api/agent/{id}", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a user agent by id.",
     *     @Model(type=UserAgentResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="agent")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @internal param ICollectionService $collectionService
     */
    public function fetchUserAgentById($id)
    {
        $data = UserAgentFactory::create($this->getDoctrine()->getRepository(UserAgent::class)->findBy(['id' => $id]))->getResponse();

        return $this->json($data);
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