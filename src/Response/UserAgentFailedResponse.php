<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 10.11.2018
 * Time: 23:42
 */

namespace App\Response;

/**
 * Class UserAgentFailedResponse
 * @package App\Response
 */
class UserAgentFailedResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'User agent information incomplete. Check your credentials.'], $this->jsonResponse::HTTP_BAD_REQUEST);
    }
}