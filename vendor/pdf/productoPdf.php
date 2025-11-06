<?php
require_once __DIR__ . '/../fpdf/fpdf.php';

class ProductoPDF extends FPDF {
    private $productos;
    private $uploadPath;
    private $logoPath;

    public function __construct($productos) {
        parent::__construct('L', 'mm', 'A4'); // Orientación horizontal
        $this->productos = $productos;

        // Ruta de imágenes
        $this->uploadPath = realpath(__DIR__ . '/../../../uploads/');
        if (!$this->uploadPath) {
            $this->uploadPath = 'C:/xampp/htdocs/ProyectoVenta/uploads/';
        }

        $this->logoPath = realpath($this->uploadPath . '/incos.png');
        if (!$this->logoPath || !file_exists($this->logoPath)) {
            $this->logoPath = 'C:/xampp/htdocs/ProyectoVenta/uploads/incos.png'; // fallback
        }
    }

    public function Header() {
        // Título
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(33, 37, 41);
        $this->Ln(10);
        $this->Cell(0, 10, utf8_decode('Reporte de Productos'), 0, 1, 'C');

        // Logo
        if ($this->logoPath && file_exists($this->logoPath)) {
            $this->Image($this->logoPath, 260, 8, 20); // Ajustado para orientación horizontal
        }

        $this->Ln(10); // Espacio debajo del encabezado
    }

    public function generate() {
        $this->AddPage();

        // Encabezados de tabla
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(173, 208, 255); // Azul claro
        $this->SetTextColor(0);

        $this->Cell(15, 10, 'ID', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Nombre', 1, 0, 'C', true);
        $this->Cell(60, 10, utf8_decode('Descripción'), 1, 0, 'C', true);
        $this->Cell(30, 10, 'Precio', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Stock', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Proveedor', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Imagen', 1, 1, 'C', true);

        // Datos
        $this->SetFont('Arial', '', 11);
        $rowHeight = 40;

        foreach ($this->productos as $producto) {
            $this->Cell(15, $rowHeight, $producto['id_producto'], 1);
            $this->Cell(40, $rowHeight, utf8_decode($producto['nombre']), 1);
            $this->Cell(60, $rowHeight, utf8_decode($producto['descripcion'] ?: 'Sin descripción'), 1);
            $this->Cell(30, $rowHeight, number_format($producto['precio'], 2), 1);
            $this->Cell(30, $rowHeight, $producto['stock'], 1);
            $this->Cell(40, $rowHeight, utf8_decode($producto['razon_social'] ?: 'Sin proveedor'), 1);

            // Imagen
            $imageFile = preg_replace('/^uploads\//i', '', $producto['imagen']);
            $imagePath = $this->uploadPath . '/' . $imageFile;

            if ($imageFile && file_exists($imagePath)) {
                $this->Cell(40, $rowHeight, '', 1);
                $xImg = $this->GetX() - 40;
                $yImg = $this->GetY();
                $this->Image($imagePath, $xImg, $yImg, 40, $rowHeight);
            } else {
                $this->Cell(40, $rowHeight, 'Sin imagen', 1);
            }

            $this->Ln($rowHeight);
        }

        // Pie de página "Generado el"
        $this->Ln(5);
        $this->SetFont('Arial', 'I', 11);
        $this->SetTextColor(80);
        $this->Cell(0, 10, 'Generado el: ' . date('d/m/Y H:i'), 0, 1, 'R');

        $this->Output('reporte_productos.pdf', 'I');
        exit;
    }
}
