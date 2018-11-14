<?php
/**
 * Created by PhpStorm.
 * User: Til
 * Date: 14.11.2018
 * Time: 08:40
 */

namespace App\Response;

/**
 * Class ForgotPasswordFailedResponse
 * @package App\Response
 */
class ForgotPasswordFailedResponse extends AbstractResponse
{

    public function fetch(string $jsonResponse, array $data = [])
    {
        return $this->jsonResponse::create(['response' => 'Password recovering failed. Please check your credentials.'], $this->jsonResponse::HTTP_BAD_REQUEST);
    }
}