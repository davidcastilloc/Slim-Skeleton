<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Controller\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class DefaultController extends BaseController
{
    private const API_VERSION = '1.0.0';
    public function __invoke(Request $request, Response $response, $args)
    {
        // Lógica específica del controlador UserController
        // Llamar a la lógica común del BaseController
        parent::__invoke($request, $response, $args);
    }

    public function getHelp($request, $response)
    {
        $endpoints = [
            'certificados' =>  'certificados',
            'eventos' =>  'eventos',
            'docs' =>  'docs/',
            'status' =>  'status',
            'Ayuda' =>  '',
        ];
        $message = [
            'endpoints' => $endpoints,
            'version' => self::API_VERSION,
            'timestamp' => time(),
        ];
        return $this->jsonResponse($response, 'success', $message, 200);
    }

    public function getStatus($request, $response)
    {
        $status = [
            'MySQL' => 'OK',
            'version' => self::API_VERSION,
            'timestamp' => time(),
        ];

        return $this->jsonResponse($response, 'success', $status, 200);
    }
}
