<?php
require_once __DIR__ . '/../fpdf/fpdf.php';

class ClientePDF extends FPDF {
    private $clientes;
    private $logoPath;

    public function __construct($clientes) {
        parent::__construct('P', 'mm', 'A4'); // vertical
        $this->clientes = $clientes;

        // Ruta al logo (igual que en UsuarioPDF)
        $this->logoPath = realpath(__DIR__ . '/../../../uploads/incos.png');
        if (!$this->logoPath || !file_exists($this->logoPath)) {
            $this->logoPath = 'C:/xampp/htdocs/ProyectoVenta/uploads/incos.png'; // Ajusta si usas otro path
        }
    }

    public function Header() {
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(33, 37, 41);
        $this->Ln(10);
        $this->Cell(0, 10, utf8_decode('Reporte de Clientes'), 0, 1, 'C');

        if ($this->logoPath && file_exists($this->logoPath)) {
            $this->Image($this->logoPath, 165, 8, 20);
        }

        $this->Ln(10);
    }

    public function generate() {
        $this->AddPage();

        // Encabezados de la tabla con fondo azul claro
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(173, 208, 255);
        $this->SetTextColor(0);

        $this->Cell(15, 10, 'ID', 1, 0, 'C', true);
        $this->Cell(65, 10, 'Nombre', 1, 0, 'C', true);
        $this->Cell(60, 10, 'Email', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Telefono', 1, 1, 'C', true);

        // Filas con datos
        $this->SetFont('Arial', '', 11);
        foreach ($this->clientes as $cliente) {
            $nombreCompleto = utf8_decode(
                trim($cliente['nombre'] . ' ' . $cliente['apellido_paterno'] . ' ' . $cliente['apellido_materno'])
            );
            $this->Cell(15, 10, $cliente['id_cliente'], 1, 0, 'C');
            $this->Cell(65, 10, $nombreCompleto, 1, 0, 'L');
            $this->Cell(60, 10, $cliente['email'], 1, 0, 'L');
            $telefono = $cliente['telefono'] ?: 'N/A';
            $this->Cell(40, 10, $telefono, 1, 1, 'C');
        }

        $this->Ln(10);

        // Pie con fecha generado el
        $this->SetFont('Arial', 'I', 11);
        $this->SetTextColor(80);
        $this->Cell(0, 10, 'Generado el: ' . date('d/m/Y H:i'), 0, 1, 'R');

        $this->Output('reporte_clientes.pdf', 'I');
        exit;
    }
}
