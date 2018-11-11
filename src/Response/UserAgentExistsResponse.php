<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 10.11.2018
 * Time: 23:44
 */

namespace App\Response;

/**
 * Class UserAgentExistsResponse
 * @package App\Response
 */
class UserAgentExistsResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'User agent already exists.'], $this->jsonResponse::HTTP_CONFLICT);
    }
}