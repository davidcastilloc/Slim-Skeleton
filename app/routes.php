<?php

declare(strict_types=1);

use Slim\App;
use App\Application\Repository\CertificationRepository;
use App\Application\Entity\CertificationEntity;
use App\Application\Controller\{Certificados\GenerarPdf, DataController, DefaultController};
use Slim\Exception\HttpNotFoundException;

return function (App $app) {
    $app->get('/', DefaultController::class . ":getHelp");

    $app->post('/administracion/segura/importar', DataController::class);

    $app->get('/validar', function ($request, $response, array $args) {
        $database = $this->get(PDO::class);
        $db = new CertificationRepository($database);
        $data = $request->getParsedBody();
        $response->getBody()->write(json_encode($db->checkAndGetCert($data["id"])->toJson()));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/getallcertsbyid/{documentodeidentidad}/{eventId}', function ($request, $response, array $args) {
        $database = $this->get(PDO::class);
        $rcert = new CertificationRepository($database);
        $generador = new GenerarPdf();
        $result = $rcert->getCertsByDocumentIdAndEventId($args["documentodeidentidad"],$args["eventId"]);
        if (count($result) === 0) {
            throw new HttpNotFoundException($request, "Este documento no tiene certificados registrados!");
        }
        foreach ($result as $key => $certificado) {
            $generador->agregarCertificado($certificado["nombreCompleto"], $certificado["tipoParticipacion"],
                $certificado["plantillaCertificado"]);
        }
        $generador->generate();
    });

    $app->get('/generar/{id}', function ($request, $response, array $args) {
        $database = $this->get(PDO::class);
        $generador = new GenerarPdf();
        $db = new CertificationRepository($database);
        $nombre_certificado = $db->checkAndGetCert($args['id'])->getNombreCompleto();
        $generador->agregarCertificado($nombre_certificado);
        $generador->generate();
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
        $e_certificado->setplantillaCertificado($data["evento_id"]);
        $r_certification->createCert($e_certificado);
        $response->getBody()->write(json_encode($e_certificado->toJson()));
        return $response;
    });

    $app->get('/getEventos', function ($request, $response, array $args) {
        $database = $this->get(PDO::class);
        $query = 'SELECT * FROM `evento` ORDER BY `id`';
        $statement = $database->prepare($query);
        $statement->execute();
        $response->getBody()->write(json_encode($statement->fetchAll()));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->post('/uploadPlantilla', function ($request, $response, $args) {
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['plantilla'];
        //Agregar fecha y hora actual al nombre del archivo
        $currentDateTime = new DateTime();
        $formattedDateTime = $currentDateTime->format('Ymd_His');
        $newFilename = $formattedDateTime . '_' . $uploadedFile->getClientFilename();
        $uploadedFile->moveTo("uploads/plantilla/$newFilename");
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $result = [
                'code' => 200,
                'status' => "GOOD",
                'message' => "Archivo subido exitosamente.",
                'nombreArchivo' => $newFilename
            ];
            $response->getBody()->write(json_encode($result));
        } else {
            $result = [
                'code' => 500,
                'status' => "BAD",
                'message' => "Error al subir el archivo.",
                'nombreArchivo' => $newFilename
            ];
            $response->getBody()->write(json_encode($result));
        }
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->post('/crearEvento', function ($request, $response, array $args) {
        $newEvento = $request->getParsedBody();
        $database = $this->get(PDO::class);
        $query = 'INSERT INTO `evento`(`nombre`, `fecha`, `lugar`,
        `asistenciaRequerida`, `plantillaCertificado`)
        VALUES(:nombre, :fecha, :lugar, :asistenciaRequerida, :plantillaCertificado)';
        $statement = $database->prepare($query);
        $statement->bindParam(':nombre', $newEvento["nombre"]);
        $statement->bindParam(':fecha', $newEvento["fecha"]);
        $statement->bindParam(':lugar', $newEvento["lugar"]);
        $statement->bindParam(':asistenciaRequerida', $newEvento["asistenciaRequerida"]);
        $statement->bindParam(':plantillaCertificado', $newEvento["plantillaCertificado"]);
        $statement->execute();
        $response->getBody()->write(json_encode($newEvento));
        return $response->withHeader('Content-Type', 'application/json');
    });
};