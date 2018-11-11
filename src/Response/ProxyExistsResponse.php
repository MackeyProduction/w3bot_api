<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 11.11.2018
 * Time: 00:17
 */

namespace App\Response;

/**
 * Class ProxyExistsResponse
 * @package App\Response
 */
class ProxyExistsResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'Proxy already exists.'], $this->jsonResponse::HTTP_CONFLICT);
    }
}