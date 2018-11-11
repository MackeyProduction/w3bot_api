<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 11.11.2018
 * Time: 13:39
 */

namespace App\Response;

/**
 * Class AuthorizationSuccessResponse
 * @package App\Response
 */
class AuthorizationSuccessResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'The authorization was successful.'], $this->jsonResponse::HTTP_OK);
    }
}