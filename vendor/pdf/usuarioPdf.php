<?php
require_once __DIR__ . '/../fpdf/fpdf.php';

class UsuarioPDF extends FPDF {
    private $usuarios;
    private $logoPath;

    public function __construct($usuarios) {
        parent::__construct('P', 'mm', 'A4'); // Modo vertical
        $this->usuarios = $usuarios;

        // Ruta al logo
        $this->logoPath = realpath(__DIR__ . '/../../../uploads/incos.png');
        if (!$this->logoPath || !file_exists($this->logoPath)) {
            $this->logoPath = 'C:/xampp/htdocs/ProyectoVenta/uploads/incos.png'; // Ajusta si usas otro nombre de proyecto
        }
    }

    public function Header() {
        // Título
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(33, 37, 41);
         $this->Ln(10);
        $this->Cell(0, 10, utf8_decode('Reporte de Usuarios'), 0, 1, 'C');
       

        // Imagen del logo
        if ($this->logoPath && file_exists($this->logoPath)) {
            $this->Image($this->logoPath, 165, 8, 20); // Posición X ajustada para modo vertical
        }

        $this->Ln(10); // Espaciado debajo del encabezado
    }

    

    public function generate() {
        $this->AddPage();

        // Encabezados
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(173, 208, 255); // Azul claro
        $this->SetTextColor(0);

        $this->Cell(10, 10, 'ID', 1, 0, 'C', true);
        $this->Cell(70, 10, 'Nombre completo', 1, 0, 'C', true);
        $this->Cell(60, 10, 'Email', 1, 0, 'C', true);
        $this->Cell(25, 10, 'Tipo', 1, 0, 'C', true);
        $this->Cell(25, 10, 'Estado', 1, 1, 'C', true);

        // Filas
        $this->SetFont('Arial', '', 11);
        foreach ($this->usuarios as $usuario) {
            $nombreCompleto = utf8_decode($usuario['nombre'] . ' ' . $usuario['apellido_paterno'] . ' ' . $usuario['apellido_materno']);
            $this->Cell(10, 10, $usuario['id_usuario'], 1, 0, 'C');
            $this->Cell(70, 10, $nombreCompleto, 1, 0, 'L');
            $this->Cell(60, 10, $usuario['email'], 1, 0, 'L');
            $this->Cell(25, 10, ucfirst($usuario['tipo_usuario']), 1, 0, 'C');
            $this->Cell(25, 10, ucfirst($usuario['estado']), 1, 1, 'C');
        }
        $this->Ln(10); // Espacio debajo de la tabla
        $this->SetFont('Arial', 'I', 11);
        $this->SetTextColor(80); // Gris suave
        $this->Cell(0, 10, 'Generado el: ' . date('d/m/Y H:i'), 0, 1, 'R');

        $this->Output('reporte_usuarios.pdf', 'I');
        exit;
    }
}
