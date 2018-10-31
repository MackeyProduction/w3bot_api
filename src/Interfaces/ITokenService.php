<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 31.10.2018
 * Time: 21:49
 */

namespace App\Interfaces;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface ITokenService
 * @package App\Interfaces
 */
interface ITokenService
{
    /**
     * @param Request $request
     * @return \Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\PreAuthenticationJWTUserToken
     */
    public function getCredentials(Request $request);

    /**
     * @param $request
     * @return array
     */
    public function getPayload(Request $request);

    /**
     * @param Request $request
     * @param array $data
     * @return JsonResponse
     */
    public function getTokenResponse(Request $request, $data = []);
}