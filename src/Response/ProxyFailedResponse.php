<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 11.11.2018
 * Time: 00:16
 */

namespace App\Response;

/**
 * Class ProxyFailedResponse
 * @package App\Response
 */
class ProxyFailedResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'Proxy information incomplete. Check your credentials.'], $this->jsonResponse::HTTP_BAD_REQUEST);
    }
}