<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 19:09
 */

namespace App\Response;

use App\Service\ResponseService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserLoginFailedResponse
 * @package App\Response
 */
class UserLoginFailedResponse extends AbstractResponse
{
    /**
     * @param string $responseType
     * @return JsonResponse
     */
    public function fetch(string $responseType)
    {
        return $this->jsonResponse::create(['response' => 'User login failed. Check your user credentials.'], $this->jsonResponse::HTTP_FORBIDDEN);
    }
}
