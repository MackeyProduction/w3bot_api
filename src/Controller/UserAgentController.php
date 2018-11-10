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

                    return $tokenService->getTokenResponse($request, ['response' => 'User agent inserted successfully.']);
                } else {
                    return $tokenService->getTokenResponse($request, ['response' => 'User agent already exists.']);
                }
            } else {
                return $tokenService->getTokenResponse($request, ['response' => 'User agent information incomplete. Check your credentials.']);
            }
        }

        return $tokenService->getTokenResponse($request);
    }
}