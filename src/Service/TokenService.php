<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 31.10.2018
 * Time: 20:29
 */

namespace App\Service;

use App\Interfaces\ITokenService;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator as BaseAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class TokenService
 * @package App\Service
 */
class TokenService extends BaseAuthenticator implements ITokenService
{
    /**
     * TokenService constructor.
     * @param JWTTokenManagerInterface $jwtManager
     * @param EventDispatcherInterface $dispatcher
     * @param TokenExtractorInterface $tokenExtractor
     */
    public function __construct(JWTTokenManagerInterface $jwtManager, EventDispatcherInterface $dispatcher, TokenExtractorInterface $tokenExtractor)
    {
        parent::__construct($jwtManager, $dispatcher, $tokenExtractor);
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
     * @param Request $request
     * @param array $data
     * @return JsonResponse
     */
    public function getTokenResponse(Request $request, $data = [])
    {
        return JsonResponse::create([
            'token' => $this->getCredentials($request),
            'payload' => $this->getPayload($request),
            'data' => $data,
        ], JsonResponse::HTTP_OK);
    }
}