<?php
/**
 * Created by PhpStorm.
 * User: Til
 * Date: 14.11.2018
 * Time: 08:58
 */

namespace App\Response;

/**
 * Class ForgotPasswordSuccessResponse
 * @package App\Response
 */
class ForgotPasswordSuccessResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'Password recovering was successful.'], $this->jsonResponse::HTTP_OK);
    }
}