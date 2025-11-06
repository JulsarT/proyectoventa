<?php
require_once __DIR__ . '/../fpdf/fpdf.php';

class CompraPDF extends FPDF {
    private $compras;
    private $logoPath;

    public function __construct($compras) {
        parent::__construct('P', 'mm', 'A4'); // ← Ahora en vertical
        $this->compras = $compras;

        $this->logoPath = realpath(__DIR__ . '/../../../uploads/incos.png');
        if (!$this->logoPath || !file_exists($this->logoPath)) {
            $this->logoPath = 'C:/xampp/htdocs/ProyectoVenta/uploads/incos.png';
        }
    }

    public function Header() {
        if ($this->logoPath && file_exists($this->logoPath)) {
            $this->Image($this->logoPath, 180, 8, 20); // Ajuste para hoja vertical
        }

        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(33, 37, 41);
        $this->Ln(10);
        $this->Cell(0, 10, utf8_decode('Reporte de Compras'), 0, 1, 'C');
        $this->Ln(10);
    }

    public function generate() {
        $this->AddPage();

        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor(173, 208, 255);
        $this->SetTextColor(0);

        $this->Cell(10, 10, 'ID', 1, 0, 'C', true);
        $this->Cell(55, 10, 'Usuario', 1, 0, 'C', true);
        $this->Cell(45, 10, 'Proveedor', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Fecha', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Total (Bs)', 1, 1, 'C', true);

        $this->SetFont('Arial', '', 10);
        foreach ($this->compras as $compra) {
            $usuarioNombreCompleto = utf8_decode(trim(
                ($compra['nombre'] ?? '') . ' ' .
                ($compra['apellido_paterno'] ?? '') . ' ' .
                ($compra['apellido_materno'] ?? '')
            ));

            $proveedor = utf8_decode($compra['proveedor_nombre'] ?? 'N/A');
            $fecha = $compra['fecha'];
            $total = number_format($compra['total'], 2);

            $this->Cell(10, 10, $compra['id_compra'], 1, 0, 'C');
            $this->Cell(55, 10, $usuarioNombreCompleto, 1, 0, 'L');
            $this->Cell(45, 10, $proveedor, 1, 0, 'L');
            $this->Cell(40, 10, $fecha, 1, 0, 'C');
            $this->Cell(40, 10, $total, 1, 1, 'R');
        }

        $this->Ln(10);
        $this->SetFont('Arial', 'I', 11);
        $this->SetTextColor(80);
        $this->Cell(0, 10, 'Generado el: ' . date('d/m/Y H:i'), 0, 1, 'R');

        $this->Output('I', 'reporte_compras.pdf');
        exit;
    }
}
