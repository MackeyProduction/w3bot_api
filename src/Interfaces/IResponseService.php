<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 19:25
 */

namespace App\Interfaces;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface IResponseService
 * @package App\Interfaces
 */
interface IResponseService
{
    /**
     * @param string $responseType
     * @param array $data
     * @return JsonResponse
     */
    public function getJsonResponse(string $responseType, array $data = []);
}
