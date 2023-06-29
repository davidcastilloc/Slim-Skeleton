<?php

declare(strict_types=1);

namespace App\Application\Entity;

final class CertificationEntity
{
    private string $id;

    private string $documento_identidad;

    private string $cod_asistente;

    private string $nombre_completo;

    private string $tipo_participacion;

    private int $evento_id;

    //Este constructor sirve para los test ._.
    
    public function getId(): string
    {
        return $this->id;
    }

    public function getDocumento_identidad(): string
    {
        return $this->documento_identidad;
    }

    public function getCod_asistente(): string
    {
        return $this->cod_asistente;
    }

    public function getNombre_completo(): string
    {
        return $this->nombre_completo;
    }

    public function getTipoParticipacion(): string
    {
        return $this->tipo_participacion;
    }

    public function getEventoId(): int
    {
        return $this->evento_id;
    }


    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setDocumento_identidad(string $documento_identidad): void
    {
        $this->documento_identidad = $documento_identidad;
    }

    public function setCod_asistente(string $cod_asistente): void
    {
        $this->cod_asistente = $cod_asistente;
    }

    public function setNombre_completo(string $nombre_completo): void
    {
        $this->nombre_completo = $nombre_completo;
    }

    public function setTipoParticipacion(string $tipo_participacion): void
    {
        $this->tipo_participacion = $tipo_participacion;
    }


    public function setEventoId(int $evento_id): void
    {
        $this->evento_id = $evento_id;
    }

    public function toJson(): object
    {
        return json_decode((string) json_encode(get_object_vars($this)), false);
    }

}