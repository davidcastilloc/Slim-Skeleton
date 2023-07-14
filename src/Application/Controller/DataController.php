<?php

namespace App\Application\Controller;

use App\{Application\Entity\CertificationEntity,
    Application\Repository\CertificationRepository,
    Application\Exceptions\CertificationNotFoundException};
use DateTime;
use Psr\{Http\Message\ResponseInterface as Response, Http\Message\ServerRequestInterface as Request};
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class DataController extends BaseController
{
    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $uploadedFiles = $request->getUploadedFiles();
        $requestData = $request->getParsedBody();
        $uploadedFile = $uploadedFiles['csv_file'];
        if (empty($requestData['idEvento'])) {
            return $this->jsonResponse($response, "VALIDATION", "Debe seleccionar el evento!", 200);
        }
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = $uploadedFile->getClientFilename();
            //Comprobamos que es un csv
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
            if ($fileExtension !== 'csv') {
                return $this->jsonResponse($response, "PROBLEMS", 'El archivo no es un CSV valido', 400);
            }
            //Agregar fecha y hora actual al nombre del archivo
            $currentDateTime = new DateTime();
            $formattedDateTime = $currentDateTime->format('Ymd_His');
            $newFilename = $formattedDateTime . '_' . $filename;
            $uploadedFile->moveTo("uploads/$newFilename");
            //aqui procesamos el csv
            //error_log(print_r($this->processCsv($newFilename)));
            $certificadosProcesados = $this->processCsv($newFilename);
            if ($certificadosProcesados === []) {
                return $this->jsonResponse($response, "SUCCESS", "No se agregaron valores nuevos al csv", 200);
            }

            return $this->jsonResponse($response, "SUCCESS", $certificadosProcesados, 200);
        } else {
            return $this->jsonResponse($response, "SUCCESS", 'Error al subir el archivo CSV', 400);
        }
    }

    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    private function processCsv(string $newFilename): array
    {
        $csv = Reader::createFromPath("./uploads/$newFilename");
        $csv->setHeaderOffset(0);
        // Lógica para importar los datos aquí
        //$response->getBody()->write('Hola');

        //$header = $csv->getHeader(); //returns the CSV header record
        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object

        $certificados = [];
        foreach ($records as $certificado) {
            // Accede a los valores de cada registro
            $rstCertification = new CertificationRepository($this->getDatabase());
            try {
                $rstCertification->checkAndGetCert($certificado['id']);
            } catch (CertificationNotFoundException $th) {
                $certEntity = new CertificationEntity();
                $certEntity->setCodAsistente($certificado["codAsistente"]);
                $certEntity->setId($certificado['id']);
                $certEntity->setDocumentoIdentidad($certificado["documentoIdentidad"]);
                $certEntity->setEventoId($certificado["eventoId"]);
                $certEntity->setNombreCompleto($certificado["nombreCompleto"]);
                $certEntity->setTipoParticipacion($certificado["tipoParticipacion"]);
                $rstCertification->createCert($certEntity);
                $certificados[] = $certificado;
            }
        }
        return $certificados;
    }
}
