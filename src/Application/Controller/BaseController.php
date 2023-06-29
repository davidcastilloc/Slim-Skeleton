<?php

declare(strict_types=1);

namespace App\Controller;

use Slim\Container;
use Slim\Http\Response;

abstract class BaseController
{
    public function __construct(protected Container $container)
    {
    }

    protected function jsonResponse(
        Response $response,
        string $status,
        $message,
        int $code
    ): Response {
        $result = [
            'code' => $code,
            'status' => $status,
            'message' => $message,
        ];

        return $response->withJson($result, $code, JSON_PRETTY_PRINT);
    }

}
