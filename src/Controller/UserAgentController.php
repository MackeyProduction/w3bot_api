<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 25.10.2018
 * Time: 20:55
 */

namespace App\Controller;

use App\Entity\LayoutEngine;
use App\Entity\OperatingSystem;
use App\Entity\OperatingSystemName;
use App\Entity\Software;
use App\Entity\SoftwareExtras;
use App\Entity\SoftwareName;
use App\Entity\UserAgent;
use App\Factory\UserAgentFactory;
use App\Interfaces\ICollectionService;
use App\Interfaces\IResponseService;
use App\Interfaces\ITokenService;
use App\Interfaces\IUserAgent;
use App\Model\UserAgentResponseModel;
use App\Repository\UserAgentRepository;
use App\Response\QueryFetchedSuccessResponse;
use App\Response\UserAgentExistsResponse;
use App\Response\UserAgentFailedResponse;
use App\Response\UserAgentSuccessResponse;
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
     * @param IResponseService $responseService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchUserAgents(ICollectionService $collectionService, IResponseService $responseService)
    {
        $data = $this->getDoctrine()->getRepository(UserAgent::class)->findAll();
        $result = $collectionService->getCollection(UserAgentFactory::class, $data);

        return $responseService->getJsonResponse(QueryFetchedSuccessResponse::class, [ 'data' => $result ]);
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
     * @param ICollectionService $collectionService
     * @param IResponseService $responseService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchUserAgentById($id, ICollectionService $collectionService, IResponseService $responseService)
    {
        $data = $this->getDoctrine()->getRepository(UserAgent::class)->find($id);
        $result = $collectionService->getCollection(UserAgentFactory::class, [ $data ]);

        /** @var IUserAgent $data */
        return $responseService->getJsonResponse(QueryFetchedSuccessResponse::class, [ 'data' => $result ]);
    }

    /**
     * Gets a user agent by operating system name.
     *
     * @Route("/api/agent/os/name/{name}", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a user agent by operating system name.",
     *     @Model(type=UserAgentResponseModel::class, groups={"full"})
     * )
     * @SWG\Parameter(
     *     name="version",
     *     in="query",
     *     type="string",
     *     description="The field used for os version."
     * )
     * @SWG\Tag(name="agent")
     *
     * @param $name
     * @param Request $request
     * @param ICollectionService $collectionService
     * @param IResponseService $responseService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchUserAgentByOperatingSystemName($name, Request $request, ICollectionService $collectionService, IResponseService $responseService)
    {
        $data = $this->getDoctrine()->getRepository(UserAgent::class)->findByOperatingSystemName($name);

        if (!empty($request->query->get("version"))) {
            $data = $this->getDoctrine()->getRepository(UserAgent::class)->findByOperatingSystemNameAndVersion($name, $request->query->get("version"));
        }

        $result = $collectionService->getCollection(UserAgentFactory::class, $data);

        /** @var IUserAgent $data */
        return $responseService->getJsonResponse(QueryFetchedSuccessResponse::class, [ 'data' => $result ]);
    }

    /**
     * Gets all user agents grouped by operating system name.
     *
     * @Route("/api/agent/os/names", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of user agents grouped by operating system name.",
     *     @Model(type=UserAgentResponseModel::class, groups={"full"})
     * )
     * @SWG\Tag(name="agent")
     *
     * @param ICollectionService $collectionService
     * @param IResponseService $responseService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchUserAgentByOperatingSystemNameGrouped(ICollectionService $collectionService, IResponseService $responseService)
    {
        $data = $this->getDoctrine()->getRepository(UserAgent::class)->findByOperatingSystemNameGrouped();
        $result = $collectionService->getCollection(UserAgentFactory::class, $data);

        /** @var IUserAgent $data */
        return $responseService->getJsonResponse(QueryFetchedSuccessResponse::class, [ 'data' => $result ]);
    }

    /**
     * Gets a user agent by software name.
     *
     * @Route("/api/agent/software/{name}", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a user agent by software name.",
     *     @Model(type=UserAgentResponseModel::class, groups={"full"})
     * )
     * @SWG\Parameter(
     *     name="version",
     *     in="query",
     *     type="string",
     *     description="The field used for software version."
     * )
     * @SWG\Parameter(
     *     name="leVersion",
     *     in="query",
     *     type="string",
     *     description="The field used for layout engine version."
     * )
     * @SWG\Tag(name="agent")
     *
     * @param $name
     * @param Request $request
     * @param ICollectionService $collectionService
     * @param IResponseService $responseService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetchUserAgentBySoftwareName($name, Request $request, ICollectionService $collectionService, IResponseService $responseService)
    {
        $data = $this->getDoctrine()->getRepository(UserAgent::class)->findBySoftwareName($name);

        if (!empty($request->query->get("version"))) {
            $data = $this->getDoctrine()->getRepository(UserAgent::class)->findBySoftwareNameAndVersion($name, $request->query->get("version"));
        }

        if (!empty($request->query->get("leVersion"))) {
            $data = $this->getDoctrine()->getRepository(UserAgent::class)->findByLayoutEngineAndVersion($name, $request->query->get("leVersion"));
        }

        $result = $collectionService->getCollection(UserAgentFactory::class, $data);

        /** @var IUserAgent $data */
        return $responseService->getJsonResponse(QueryFetchedSuccessResponse::class, [ 'data' => $result ]);
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
     * @param Request $request
     * @param ITokenService $tokenService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postUserAgent(Request $request, ITokenService $tokenService)
    {
        if ($tokenService->getTokenResponse($request)->isSuccessful())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $agent = $request->request->get("agent");
            $softwareName = $request->request->get("softwareName");
            $softwareVersion = $request->request->get("softwareVersion");
            $softwareExtras = $request->request->get("softwareExtras");
            $layoutEngine = $request->request->get("layoutEngine");
            $layoutEngineVersion = $request->request->get("layoutEngineVersion");
            $osName = $request->request->get("osName");
            $osVersion = $request->request->get("osVersion");

            if ($softwareName != "" && $softwareVersion != "" && $layoutEngine != "" && $layoutEngineVersion != "" && $osName != "" && $osVersion != "" && $agent != "") {
                $agentResult = $this->getDoctrine()->getRepository(UserAgent::class)->findOneBy(['agent' => $agent]);
                $softwareResult = $this->getDoctrine()->getRepository(UserAgent::class)->findOneBySoftwareNameAndVersion($softwareName, $softwareVersion);
                $layoutEngineResult = $layoutEngineResult = $this->getDoctrine()->getRepository(UserAgent::class)->findOneByLayoutEngineAndVersion($layoutEngine, $layoutEngineVersion);
                $osResult = $this->getDoctrine()->getRepository(UserAgent::class)->findOneByOperatingSystemNameAndVersion($osName, $osVersion);
                $softwareExtrasResult = $this->getDoctrine()->getRepository(SoftwareExtras::class)->findOneBy(['info' => $softwareExtras]);
                $softwareNameResult = $this->getDoctrine()->getRepository(SoftwareName::class)->findOneBy(['name' => $softwareName]);
                $layoutEngineNameResult = $this->getDoctrine()->getRepository(LayoutEngine::class)->findOneBy(['name' => $layoutEngine]);
                $osNameResult = $this->getDoctrine()->getRepository(OperatingSystemName::class)->findOneBy(['name' => $osName]);

                // check if entry already exists
                if ($agentResult == null && $softwareResult == null && $layoutEngineResult == null && $osResult == null) {
                    $userAgentEntity = new UserAgent();
                    $softwareEntity = new Software();
                    $osEntity = new OperatingSystem();

                    // set software name and version in software entity
                    if ($softwareNameResult == null) {
                        $softwareNameEntity = new SoftwareName();
                        $softwareNameEntity->setName($softwareName);
                        $softwareEntity->setVersion($softwareVersion);
                        $softwareEntity->setSoftwareName($softwareNameEntity);

                        $entityManager->persist($softwareNameEntity);
                    } else {
                        /** @var SoftwareName $softwareNameResult */
                        $softwareEntity->setSoftwareName($softwareNameResult);
                        $softwareEntity->setVersion($softwareVersion);
                    }

                    // set layout engine name and version in software entity
                    if ($layoutEngineNameResult == null) {
                        $layoutEngineEntity = new LayoutEngine();
                        $layoutEngineEntity->setName($layoutEngine);
                        $softwareEntity->setLeVersion($layoutEngineVersion);
                        $softwareEntity->setLayoutEngine($layoutEngineEntity);

                        $entityManager->persist($layoutEngineEntity);
                    } else {
                        /** @var LayoutEngine $layoutEngineNameResult */
                        $softwareEntity->setLayoutEngine($layoutEngineNameResult);
                        $softwareEntity->setLeVersion($layoutEngineVersion);
                    }

                    // set operating system name and version in operating system
                    if ($osNameResult == null) {
                        $osNameEntity = new OperatingSystemName();
                        $osNameEntity->setName($osName);
                        $osEntity->setVersion($osVersion);
                        $osEntity->setOperatingSystemName($osNameEntity);

                        $entityManager->persist($osNameEntity);
                    } else {
                        /** @var OperatingSystemName $osNameResult */
                        $osEntity->setOperatingSystemName($osNameResult);
                        $osEntity->setVersion($osVersion);
                    }

                    if ($softwareExtrasResult == null) {
                        $softwareExtrasEntity = new SoftwareExtras();

                        $softwareExtrasEntity->setInfo($softwareExtras);
                        $softwareEntity->setSoftwareExtras($softwareExtrasEntity);

                        $entityManager->persist($softwareExtrasEntity);
                    } else {
                        /** @var SoftwareExtras $softwareExtrasResult */
                        $softwareEntity->setSoftwareExtras($softwareExtrasResult);
                    }

                    $userAgentEntity->setAgent($agent);
                    $userAgentEntity->setSoftware($softwareEntity);
                    $userAgentEntity->setOperatingSystem($osEntity);

                    // persist entities
                    $entityManager->persist($softwareEntity);
                    $entityManager->persist($osEntity);
                    $entityManager->persist($userAgentEntity);

                    // push to database
                    $entityManager->flush();

                    return $tokenService->getTokenResponse($request, UserAgentSuccessResponse::class);
                } else {
                    return $tokenService->getTokenResponse($request, UserAgentExistsResponse::class);
                }
            } else {
                return $tokenService->getTokenResponse($request, UserAgentFailedResponse::class);
            }
        }

        return $tokenService->getTokenResponse($request);
    }
}