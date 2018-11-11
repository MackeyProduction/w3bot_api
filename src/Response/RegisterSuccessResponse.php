<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 11.11.2018
 * Time: 15:41
 */

namespace App\Response;

/**
 * Class RegisterSuccessResponse
 * @package App\Response
 */
class RegisterSuccessResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'User registered successfully.'], $this->jsonResponse::HTTP_OK);
    }
}