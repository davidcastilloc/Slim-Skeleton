<?php

declare(strict_types=1);

namespace App\Application\Entity;

final class CertificationEntity
{
    private string $id;
    private string $documentoIdentidad;
    private string $codAsistente;
    private string $nombreCompleto;
    private string $tipoParticipacion;
    private int $eventoId;

    public function getId(): string
    {
        return $this->id;
    }
    public function getDocumentoIdentidad(): string
    {
        return $this->documentoIdentidad;
    }
    public function getCodAsistente(): string
    {
        return $this->codAsistente;
    }
    public function getNombreCompleto(): string
    {
        return $this->nombreCompleto;
    }
    public function getTipoParticipacion(): string
    {
        return $this->tipoParticipacion;
    }
    public function getEventoId(): int
    {
        return $this->eventoId;
    }
    public function setId(string $id): void
    {
        $this->id = $id;
    }
    public function setDocumentoIdentidad(string $documentoIdentidad): void
    {
        $this->documentoIdentidad = $documentoIdentidad;
    }
    public function setCodAsistente(string $codAsistente): void
    {
        $this->codAsistente = $codAsistente;
    }
    public function setNombreCompleto(string $nombreCompleto): void
    {
        $this->nombreCompleto = $nombreCompleto;
    }
    public function setTipoParticipacion(string $tipoParticipacion): void
    {
        $this->tipoParticipacion = $tipoParticipacion;
    }
    public function setEventoId(int $eventoId): void
    {
        $this->eventoId = $eventoId;
    }
    public function toJson(): object
    {
        return json_decode((string) json_encode(get_object_vars($this)), false);
    }
}
