<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 11.11.2018
 * Time: 15:39
 */

namespace App\Response;

/**
 * Class RegisterFailedResponse
 * @package App\Response
 */
class RegisterFailedResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'Registration failed. Check your credentials.'] + $data, $this->jsonResponse::HTTP_BAD_REQUEST);
    }
}