<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Application\Entity\CertificationEntity;

final class CertificationRepository extends BaseRepository
{
    public function checkAndGetCert(int $certId): CertificationEntity
    {
        $query = 'SELECT * FROM `certification` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $certId);
        $statement->execute();
        $cert = $statement->fetchObject(CertificationEntity::class);
        if (! $cert) {
           throw new \Exception("Certificado no encontrado!", 404);
        }
        return $cert;
    }

    /**
     * @return array<string>
     */
    public function getCerts(): array
    {
        $query = 'SELECT * FROM `certification` ORDER BY `id`';
        $statement = $this->database->prepare($query);
        $statement->execute();
        return (array) $statement->fetchAll();
    }

    public function createCert(CertificationEntity $certificate): CertificationEntity
    {
        $query = '
            INSERT INTO `certificacion`
                (`id`,`documento_identidad`, 
                `cod_asistente`, `nombre_completo`, 
                `tipo_participacion`,
                `evento_id`)
            VALUES
                (UUID(),:documento_identidad, 
                :cod_asistente, :nombre_completo, 
                :tipo_participacion, :evento_id)
        ';
        $statement = $this->database->prepare($query);
        $documento_identidad = $certificate->getDocumento_identidad();
        $cod_asistente = $certificate->getCod_asistente();
        $nombre_completo = $certificate->getNombre_completo();
        $tipo_participacion = $certificate->getTipoParticipacion();
        $id_evento = $certificate->getEventoId();
        $statement->bindParam(':documento_identidad', $documento_identidad);
        $statement->bindParam(':cod_asistente', $cod_asistente);
        $statement->bindParam(':nombre_completo', $nombre_completo);
        $statement->bindParam(':tipo_participacion', $tipo_participacion);
        $statement->bindParam(':evento_id', $id_evento);
        $statement->execute();
        return $certificate;
    }

    public function updateCert(CertificationEntity $certificate): CertificationEntity
    {
        $query = '
            UPDATE `certificacion`
            SET `documento_identidad` = :documento_identidad,
             `cod_asistente` = :cod_asistente, 
             `nombre_completo` = :nombre_completo, 
             `tipo_participacion` = :tipo_participacion
            `evento_id` = :evento_id
            WHERE `id` = :id
        ';
        $statement = $this->database->prepare($query);
        $id = $certificate->getId();
        $documento_identidad = $certificate->getDocumento_identidad();
        $cod_asistente = $certificate->getCod_asistente();
        $nombre_completo = $certificate->getNombre_completo();
        $tipo_participacion = $certificate->getTipoParticipacion();
        $id_evento = $certificate->getEventoId();
        $statement->bindParam(':id', $id);
        $statement->bindParam(':documento_identidad', $documento_identidad);
        $statement->bindParam(':cod_asistente', $cod_asistente);
        $statement->bindParam(':nombre_completo', $nombre_completo);
        $statement->bindParam(':tipo_participacion', $tipo_participacion);
        $statement->bindParam(':evento_id', $id_evento);
        $statement->execute();

        return $this->checkAndGetCert((int) $id);
    }

    public function deleteCert(int $certId): void
    {
        $query = 'DELETE FROM `certification` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $certId);
        $statement->execute();
    }
}
