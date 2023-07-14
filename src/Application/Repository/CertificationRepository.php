<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Application\Entity\CertificationEntity;
use App\Application\Exceptions\CertificationNotFoundException;

final class CertificationRepository extends BaseRepository
{
    public function checkAndGetCert(string $certId): CertificationEntity
    {
        $query = 'SELECT * FROM `certificacion` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $certId);
        $statement->execute();
        $cert = $statement->fetchObject(CertificationEntity::class);
        if (!$cert) {
            throw new CertificationNotFoundException("Certificado no encontrado!");
        }
        return $cert;
    }

    /**
     * @return array<string>
     */
    public function getCerts(): array
    {
        $query = 'SELECT * FROM `certificacion` ORDER BY `id`';
        $statement = $this->database->prepare($query);
        $statement->execute();
        return (array) $statement->fetchAll();
    }

    public function getCertsByDocumentIdAndEventId(string $documentoIdentidad, string $eventoId): array
    {
        $query = 'SELECT *,
       evento.plantillaCertificado
FROM certificacion
         JOIN evento ON certificacion.eventoId = evento.id
WHERE certificacion.documentoIdentidad = :documentoIdentidad and certificacion.eventoId = :eventoId
  AND certificacion.eventoId = evento.id
ORDER BY `timestamp`;';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':documentoIdentidad', $documentoIdentidad);
        $statement->bindParam(':eventoId', $eventoId);
        $statement->execute();
        return (array) $statement->fetchAll();
    }

    public function createCert(CertificationEntity $certificate): CertificationEntity
    {
        $query = '
            INSERT INTO `certificacion`
                (`id`,`documentoIdentidad`, 
                `codAsistente`, `nombreCompleto`, 
                `tipoParticipacion`,
                `eventoId`)
            VALUES
                (UUID(),:documentoIdentidad, 
                :codAsistente, :nombreCompleto, 
                :tipoParticipacion, :eventoId)
        ';
        $statement = $this->database->prepare($query);
        $documento_identidad = $certificate->getDocumentoIdentidad();
        $cod_asistente = $certificate->getCodAsistente();
        $nombre_completo = $certificate->getNombreCompleto();
        $tipo_participacion = $certificate->getTipoParticipacion();
        $id_evento = $certificate->getEventoId();
        $statement->bindParam(':documentoIdentidad', $documento_identidad);
        $statement->bindParam(':codAsistente', $cod_asistente);
        $statement->bindParam(':nombreCompleto', $nombre_completo);
        $statement->bindParam(':tipoParticipacion', $tipo_participacion);
        $statement->bindParam(':eventoId', $id_evento);
        $statement->execute();
        return $certificate;
    }

    public function deleteCert(int $certId): void
    {
        $query = 'DELETE FROM `certificacion` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $certId);
        $statement->execute();
    }
}
