<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 11.11.2018
 * Time: 21:04
 */

namespace App\Response;

/**
 * Class TokenNotExpiredResponse
 * @package App\Response
 */
class TokenNotExpiredResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'The token isn`t expired yet. Please use your current token.'], $this->jsonResponse::HTTP_BAD_REQUEST);
    }
}