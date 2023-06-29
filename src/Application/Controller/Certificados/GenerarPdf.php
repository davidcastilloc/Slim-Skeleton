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

    public function generate($nombre_certificado = 'Nombre Completo En Display', $template = 'certificado.jpg')
    {
        $this->SetTextColor(0, 0, 0);
        $this->AddPage();
        $this->Image($template, 0, 0, 297, 210, 'JPEG');
        $this->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $this->SetFont('DejaVu', '', 35);
        $this->Text(80, 105, $nombre_certificado);
        $this->SetFont('helvetica', 'B', 15);
        $this->Text(210, 147, 5);
        $this->SetFont('helvetica', 'B', 15);
        $this->Text(230, 147, 5);
        $this->Output('certificado', 'I');
    }
}
