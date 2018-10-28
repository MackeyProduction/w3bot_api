<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 17:47
 */

namespace App\Service;

use App\Interfaces\IResponseService;
use App\Response\AbstractResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ResponseService
 * @package App\Service
 */
class ResponseService implements IResponseService
{
    protected $jsonResponse;

    /**
     * ResponseService constructor.
     */
    public function __construct()
    {
        $this->jsonResponse = JsonResponse::create();
    }

    /**
     * @param string $responseType
     * @return AbstractResponse
     */
    public function getJsonResponse(string $responseType)
    {
        if (class_exists($responseType)) {
            /** @var AbstractResponse $responseType */
            $result = $responseType::create($this->jsonResponse);

            return $result->fetch($responseType);
        }

        return null;
    }
}