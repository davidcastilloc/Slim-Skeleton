<?php

declare(strict_types=1);

namespace App\Application\Controller;

use PDO;
use Psr\Http\Message\ResponseInterface as Response;

abstract class BaseController
{
    protected $database;
    protected Request $request;
    protected Response $response;
    protected array $args;

    public function __construct(PDO $database)
    {
        $this->database = $database;
    }

    protected function getDatabase()
    {
        return $this->database;
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
        $payload = json_encode($result);
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }
}
