<?php

declare(strict_types=1);

use Slim\App;
use App\Application\Controller\Certificados\GenerarPdf;
use App\Application\Repository\CertificationRepository;
use App\Application\Entity\CertificationEntity;
use App\Application\Controller\DefaultController;

return function (App $app) {
    $app->get('/', function ($request, $response, array $args) {
        $defaultController = new DefaultController();
        return $defaultController->getHelp($request, $response);
    });

    $app->get('/validar', function ($request, $response, array $args) {
        $database = $this->get(PDO::class);
        $db = new CertificationRepository($database);
        $data = $request->getParsedBody();
        $response->getBody()->write(json_encode($db->checkAndGetCert($data["id"])->toJson()));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/generar/{id}', function ($request, $response, array $args) {
        $database = $this->get(PDO::class);
        $generador = new GenerarPdf();
        $data = $request->getParsedBody();
        $db = new CertificationRepository($database);
        $nombre_certificado = $db->checkAndGetCert($args['id'])->getNombreCompleto();
        $generador->generate($nombre_certificado);
    });

    $app->post('/crear', function ($request, $response, array $args) {
        $db = $this->get(PDO::class);
        $data = $request->getParsedBody();
        $r_certification = new CertificationRepository($db);
        $e_certificado = new CertificationEntity();
        $e_certificado->setCodAsistente($data["cod_asistente"]);
        $e_certificado->setDocumentoIdentidad($data["documento_identidad"]);
        $e_certificado->setNombreCompleto($data["nombre_completo"]);
        $e_certificado->setTipoParticipacion($data["tipo_participacion"]);
        $e_certificado->setEventoId($data["evento_id"]);
        $r_certification->createCert($e_certificado);
        $response->getBody()->write(json_encode($e_certificado->toJson()));
        return $response;
    });
};
