<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 24.11.2019
 * Time: 19:09
 */

namespace App\Response;

/**
 * Class UserLogoutSuccessResponse
 * @package App\Response
 */
class UserLogoutSuccessResponse extends AbstractResponse
{

    /**
     * @param string $jsonResponse
     * @param array $data
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'User logged out successfully.'] + $data, $this->jsonResponse::HTTP_OK);
    }
}