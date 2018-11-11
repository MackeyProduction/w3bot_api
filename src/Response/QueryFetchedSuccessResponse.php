<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 11.11.2018
 * Time: 14:30
 */

namespace App\Response;

/**
 * Class QueryFetchedSuccessResponse
 * @package App\Response
 */
class QueryFetchedSuccessResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'Query fetched successfully.'] + $data, $this->jsonResponse::HTTP_OK);
    }
}