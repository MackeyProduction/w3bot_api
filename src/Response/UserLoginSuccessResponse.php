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
 * Class UserLoginSuccessResponse
 * @package App\Response
 */
class UserLoginSuccessResponse extends AbstractResponse
{
    /**
     * @param string $responseType
     * @param array $data
     * @return JsonResponse
     */
    public function fetch(string $responseType, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'User logged in successfully.'] + $data, $this->jsonResponse::HTTP_OK);
    }
}