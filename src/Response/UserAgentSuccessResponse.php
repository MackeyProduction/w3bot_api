<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 10.11.2018
 * Time: 23:31
 */

namespace App\Response;

/**
 * Class UserAgentSuccessResponse
 * @package App\Response
 */
class UserAgentSuccessResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        $this->jsonResponse::create(['response' => 'User agent inserted successfully.'], $this->jsonResponse::HTTP_OK);
    }
}