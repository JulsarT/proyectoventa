<?php
require_once __DIR__ . '/../fpdf/fpdf.php';

class VentaPDF extends FPDF {
    private $ventas;
    private $logoPath;

    public function __construct($ventas) {
        parent::__construct('P', 'mm', 'A4');
        $this->ventas = $ventas;

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
        $this->Cell(0, 10, utf8_decode('Reporte de Ventas'), 0, 1, 'C');

        if ($this->logoPath && file_exists($this->logoPath)) {
            $this->Image($this->logoPath, 165, 8, 20);
        }

        $this->Ln(10);
    }

    public function generate() {
        $this->AddPage();

        // Encabezado de tabla
        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor(173, 208, 255);
        $this->SetTextColor(0);

        $this->Cell(10, 10, 'ID', 1, 0, 'C', true);
        $this->Cell(45, 10, 'Usuario', 1, 0, 'C', true);
        $this->Cell(45, 10, 'Cliente', 1, 0, 'C', true);
        $this->Cell(45, 10, 'Fecha', 1, 0, 'C', true);
        $this->Cell(35, 10, 'Total (Bs)', 1, 1, 'C', true);

        // Filas
        $this->SetFont('Arial', '', 10);
        foreach ($this->ventas as $venta) {
            $usuarioNombreCompleto = utf8_decode(trim(
                $venta['usuario_nombre'] . ' ' .
                $venta['usuario_apellido_paterno'] . ' ' .
                $venta['usuario_apellido_materno']
            ));

            $clienteNombreCompleto = utf8_decode(trim(
                $venta['cliente_nombre'] . ' ' .
                $venta['cliente_apellido_paterno'] . ' ' .
                $venta['cliente_apellido_materno']
            ));

            $fecha = $venta['fecha'];
            $total = number_format($venta['total'], 2);

            $this->Cell(10, 10, $venta['id_venta'], 1, 0, 'C');
            $this->Cell(45, 10, $usuarioNombreCompleto ?: 'N/A', 1, 0, 'L');
            $this->Cell(45, 10, $clienteNombreCompleto ?: 'N/A', 1, 0, 'L');
            $this->Cell(45, 10, $fecha, 1, 0, 'C');
            $this->Cell(35, 10, $total, 1, 1, 'R');
        }

        $this->Ln(10);
        $this->SetFont('Arial', 'I', 11);
        $this->SetTextColor(80);
        $this->Cell(0, 10, 'Generado el: ' . date('d/m/Y H:i'), 0, 1, 'R');

        $this->Output('reporte_ventas.pdf', 'I');
        exit;
    }
}
