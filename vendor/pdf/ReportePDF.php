<?php
require_once __DIR__ . '/../fpdf/fpdf.php';


class ReportePDF extends FPDF {
    private $logoPath;

    public function __construct() {
        parent::__construct('P', 'mm', 'A4');
        // Ruta al logo
        $this->logoPath = realpath(__DIR__ . '/../../../uploads/incos.png');
        if (!$this->logoPath || !file_exists($this->logoPath)) {
            $this->logoPath = 'C:/xampp/htdocs/ProyectoVenta/uploads/incos.png';
        }
    }

   function Header()
    {
        // Logo (si lo tienes)
        $logoPath = __DIR__ . '/../../public/img/logo.png';
        if (file_exists($logoPath)) {
            $this->Image($logoPath, 10, 8, 20);
        }

        // Encabezado
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Sistema de Ventas - Reporte de Ventas'), 0, 1, 'C');
        $this->Ln(5);
    }

    
    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }


    // Formato tabla
    public function generarTabla($cabeceras, $datos, $anchoCol = []) {
        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor(173, 208, 255);
        $this->SetTextColor(0);

        // Encabezado
        foreach ($cabeceras as $i => $cab) {
            $w = $anchoCol[$i] ?? 40;
            $this->Cell($w, 10, utf8_decode($cab), 1, 0, 'C', true);
        }
        $this->Ln();

        // Filas
        $this->SetFont('Arial', '', 10);
        foreach ($datos as $fila) {
            foreach ($fila as $i => $valor) {
                $w = $anchoCol[$i] ?? 40;
                $this->Cell($w, 8, utf8_decode($valor), 1, 0, 'C');
            }
            $this->Ln();
        }
    }

    public function exportar($nombreArchivo = 'reporte.pdf') {
        $this->Output($nombreArchivo, 'I');
        exit;
    }
}
