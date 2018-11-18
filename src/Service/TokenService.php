<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 31.10.2018
 * Time: 20:29
 */

namespace App\Service;

use App\Entity\Token;
use App\Interfaces\IResponseService;
use App\Interfaces\ITokenService;
use App\Interfaces\IUserService;
use App\Response\AuthorizationSuccessResponse;
use App\Response\QueryNotExistResponse;
use App\Response\TokenNotExpiredResponse;
use App\Response\TokenRefreshSuccessResponse;
use App\Response\UserLoginSuccessResponse;
use Doctrine\Common\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\ExpiredTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator as BaseAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\RememberMe\PersistentTokenInterface;
use Symfony\Component\Security\Core\Authentication\RememberMe\TokenProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class TokenService
 * @package App\Service
 */
class TokenService extends BaseAuthenticator implements ITokenService
{
    private $jwtManager;
    private $responseService;
    private $managerRegistry;

    /**
     * TokenService constructor.
     * @param JWTTokenManagerInterface $jwtManager
     * @param EventDispatcherInterface $dispatcher
     * @param TokenExtractorInterface $tokenExtractor
     * @param IResponseService $responseService
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(JWTTokenManagerInterface $jwtManager, EventDispatcherInterface $dispatcher, TokenExtractorInterface $tokenExtractor, IResponseService $responseService, ManagerRegistry $managerRegistry)
    {
        parent::__construct($jwtManager, $dispatcher, $tokenExtractor);

        $this->jwtManager = $jwtManager;
        $this->responseService = $responseService;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @param Request $request
     * @return \Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\PreAuthenticationJWTUserToken
     */
    public function getCredentials(Request $request)
    {
        return parent::getCredentials($request)->getCredentials();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getPayload(Request $request)
    {
        return parent::getCredentials($request)->getPayload();
    }

    /**
     * @param $oldToken
     * @param IUserService $userService
     * @return JsonResponse
     */
    public function refreshToken($oldToken, IUserService $userService)
    {
        $expiredToken = $this->managerRegistry->getRepository(Token::class)->findOneBy(['token' => $oldToken]);

        if ($expiredToken == null) {
            return $this->responseService->getJsonResponse(QueryNotExistResponse::class);
        }

        $user = $expiredToken->getUser();
        $expireDate = $expiredToken->getExpireDate();
        $currentDate = new DateTime();

        // is current token not expired?
        if ($currentDate < $expireDate) {
            return $this->responseService->getJsonResponse(TokenNotExpiredResponse::class);
        }

        // fetch user interface and map
        $mappedUser = $userService->mapUserCredentials($user);
        $token = $this->jwtManager->create($mappedUser);

        return $this->responseService->getJsonResponse(TokenRefreshSuccessResponse::class, ['token' => $token]);
    }

    /**
     * @param Request $request
     * @param string $responseType
     * @param array $data
     * @return JsonResponse
     */
    public function getTokenResponse(Request $request, string $responseType = AuthorizationSuccessResponse::class, $data = [])
    {
        try {
            if ($request->headers->get("Authorization")) {
                return $this->responseService->getJsonResponse($responseType, [
                    'token' => $this->getCredentials($request),
                    'payload' => $this->getPayload($request),
                    'data' => $data
                ]);
            }
        } catch (ExpiredTokenException $exception) {
            return JsonResponse::create(['response' => 'The current token is expired. Please refresh your token.'], JsonResponse::HTTP_FORBIDDEN);
        }

        return JsonResponse::create([ "response" => "An error occurred. Please check your credentials." ], JsonResponse::HTTP_BAD_REQUEST);
    }
}