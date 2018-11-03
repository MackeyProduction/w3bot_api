<?php
/**
 * Created by PhpStorm.
 * User: Til Anheier
 * Date: 28.10.2018
 * Time: 19:24
 */

namespace App\Response;

use App\Interfaces\IResponseService;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AbstractResponse
{
    protected $jsonResponse;

    /**
     * AbstractResponse constructor.
     * @param JsonResponse $jsonResponse
     */
    public function __construct(JsonResponse $jsonResponse)
    {
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * @param JsonResponse $jsonResponse
     * @return static
     */
    public static function create(JsonResponse $jsonResponse)
    {
        return new static($jsonResponse);
    }

    abstract public function fetch(string $jsonResponse, array $data = []);
}