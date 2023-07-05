<?php

declare(strict_types=1);

namespace App\Application\Controller\Certificados;

class GenerarPdf extends \tFPDF
{
    /**
     * Summary of __construct
     * @param mixed $orientation
     * @param mixed $unit
     * @param mixed $size
     */
    public function __construct(
        $orientation = 'L',
        $unit = 'mm',
        $size = 'A4',
    ) {
        parent::__construct($orientation, $unit, $size);
    }

    public function generate()
    {
        $this->Output('certificado', 'I');
    }

    public function agregarCertificado(
        $nombre_certificado = 'Nombre Completo En Display',
        $tipo_participacion = 'Asistente',
        $template = 'certificado.jpg'
    ) {
        $this->SetTitle("ASONAP " . $nombre_certificado);
        $this->SetCreator("ASONAP");
        $this->SetAuthor("ASONAP");
        $this->SetTextColor(0, 0, 0);
        $this->AddPage();
        $this->Image($template, 0, 0, 297, 210, 'JPEG');
        $this->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $this->SetFont('DejaVu', '', 15);
        $this->Text(56, 128, $tipo_participacion);
        $this->SetFont('DejaVu', '', 35);
        $this->Text(80, 105, $nombre_certificado);
    }
}
