<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 11.11.2018
 * Time: 20:51
 */

namespace App\Response;

/**
 * Class TokenRefreshFailedResponse
 * @package App\Response
 */
class TokenRefreshFailedResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'Token refresh failed. Please check your credentials.'], $this->jsonResponse::HTTP_BAD_REQUEST);
    }
}