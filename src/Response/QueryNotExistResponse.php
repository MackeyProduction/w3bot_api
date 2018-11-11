<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 11.11.2018
 * Time: 14:22
 */

namespace App\Response;

/**
 * Class QueryNotExistResponse
 * @package App\Response
 */
class QueryNotExistResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'The requested query dousn`t exist.'], $this->jsonResponse::HTTP_CONFLICT);
    }
}