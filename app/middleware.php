<?php

declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use Slim\Middleware\MethodOverrideMiddleware;
use Slim\Routing\RouteContext;
use Slim\App;

return function (App $app) {
	$app->add(SessionMiddleware::class);
	// Middleware para permitir solicitudes CORS
	$app->add(function ($request, $handler) {
		$response = $handler->handle($request);
		$routeContext = RouteContext::fromRequest($request);
		$routingResults = $routeContext->getRoutingResults();
		$methods = $routingResults->getAllowedMethods();
		$response = $response
			->withHeader('Access-Control-Allow-Origin', '192.168.1.53')
			->withHeader('Access-Control-Allow-Methods', implode(', ', $methods))
			->withHeader('Access-Control-Allow-Headers', 'Content-Type');
		return $response;
	});
};