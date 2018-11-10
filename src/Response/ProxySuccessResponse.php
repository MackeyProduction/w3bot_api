<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 11.11.2018
 * Time: 00:16
 */

namespace App\Response;

/**
 * Class ProxySuccessResponse
 * @package App\Response
 */
class ProxySuccessResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'Proxy inserted successfully.'], $this->jsonResponse::HTTP_OK);
    }
}