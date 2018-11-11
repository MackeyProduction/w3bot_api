<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 11.11.2018
 * Time: 20:49
 */

namespace App\Response;

/**
 * Class TokenRefreshSuccessResponse
 * @package App\Response
 */
class TokenRefreshSuccessResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'Token refreshed successfully.'] + $data, $this->jsonResponse::HTTP_OK);
    }
}