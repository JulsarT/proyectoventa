<?php
require_once __DIR__ . '/../fpdf/fpdf.php';

class ProveedorPDF extends FPDF {
    private $proveedores;
    private $logoPath;

    public function __construct($proveedores) {
        parent::__construct('P', 'mm', 'A4');
        $this->proveedores = $proveedores;

        // Ruta al logo
        $this->logoPath = realpath(__DIR__ . '/../../../uploads/incos.png');
        if (!$this->logoPath || !file_exists($this->logoPath)) {
            $this->logoPath = 'C:/xampp/htdocs/ProyectoVenta/uploads/incos.png';
        }
    }

    public function Header() {
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(33, 37, 41);
        $this->Ln(10);
        $this->Cell(0, 10, utf8_decode('Reporte de Proveedores'), 0, 1, 'C');

        if ($this->logoPath && file_exists($this->logoPath)) {
            $this->Image($this->logoPath, 165, 8, 20);
        }

        $this->Ln(10);
    }

    public function generate() {
        $this->AddPage();

        // Encabezados
        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor(173, 208, 255);
        $this->SetTextColor(0);

        $this->Cell(10, 10, 'ID', 1, 0, 'C', true);
        $this->Cell(45, 10, utf8_decode('Razón Social'), 1, 0, 'C', true);
        $this->Cell(25, 10, 'NIT', 1, 0, 'C', true);
        $this->Cell(35, 10, 'Contacto', 1, 0, 'C', true);
        $this->Cell(35, 10, 'Telefono', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Direccion', 1, 1, 'C', true);

        // Filas de datos
        $this->SetFont('Arial', '', 10);
        foreach ($this->proveedores as $proveedor) {
            $telefono = $proveedor['telefono'] ?: 'N/A';
            $direccion = $proveedor['direccion'] ?: 'N/A';
            $contacto = $proveedor['contacto'] ?: 'N/A';

            $this->Cell(10, 10, $proveedor['id_proveedor'], 1, 0, 'C');
            $this->Cell(45, 10, utf8_decode($proveedor['razon_social']), 1, 0, 'L');
            $this->Cell(25, 10, $proveedor['nit'], 1, 0, 'C');
            $this->Cell(35, 10, utf8_decode($contacto), 1, 0, 'L');
            $this->Cell(35, 10, utf8_decode($telefono), 1, 0, 'C');
            $this->Cell(40, 10, utf8_decode($direccion), 1, 1, 'L');
        }

        $this->Ln(10);

        // Pie de página con fecha
        $this->SetFont('Arial', 'I', 11);
        $this->SetTextColor(80);
        $this->Cell(0, 10, 'Generado el: ' . date('d/m/Y H:i'), 0, 1, 'R');

        $this->Output('reporte_proveedores.pdf', 'I');
        exit;
    }
}
