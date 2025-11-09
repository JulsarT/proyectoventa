<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../vendor/pdf/ReportePDF.php';
require_once __DIR__ . '/../modelo/Venta.php';
require_once __DIR__ . '/../modelo/Producto.php';
require_once __DIR__ . '/../modelo/Cliente.php';

class ReporteController extends Controller
{

    public function index()
    {
        $data['title'] = 'Reportes del Sistema';
        // Carga la vista que mostrará los botones de los reportes
        $this->view('reportes/index', $data);
    }

    public function ventasCompletas()
    {
        $ventaModel = new Venta();
        $pdf = new ReportePDF();
        $pdf->AddPage();

        // 🔹 Título principal
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Reporte de Ventas Completas', 0, 1, 'C');
        $pdf->Ln(5);

        // 🔹 Obtener todas las ventas con su cliente y usuario
        $ventas = $ventaModel->getAllVentasConUsuarioCliente();

        require_once __DIR__ . '/../modelo/DetalleVenta.php';
        $detalleModel = new DetalleVenta();

        $totalGeneral = 0;

        foreach ($ventas as $v) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, "Venta #{$v['id_venta']} - Fecha: {$v['fecha']}", 0, 1, 'L');
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(0, 8, "Cliente: " . trim($v['cliente_nombre'] . ' ' . $v['cliente_apellido_paterno']), 0, 1, 'L');
            $pdf->Cell(0, 8, "Vendedor: " . trim($v['usuario_nombre'] . ' ' . $v['usuario_apellido_paterno']), 0, 1, 'L');
            $pdf->Ln(4);

            // 🔹 Encabezado de tabla de productos
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->SetFillColor(200, 255, 200);
            $pdf->Cell(70, 8, 'Producto', 1, 0, 'C', true);
            $pdf->Cell(30, 8, 'Cantidad', 1, 0, 'C', true);
            $pdf->Cell(40, 8, 'Precio Unitario (Bs)', 1, 0, 'C', true);
            $pdf->Cell(40, 8, 'Subtotal (Bs)', 1, 1, 'C', true);

            // 🔹 Detalles de la venta
            $detalles = $detalleModel->getDetallesPorVenta($v['id_venta']);
            $pdf->SetFont('Arial', '', 10);
            $totalVenta = 0;

            foreach ($detalles as $d) {
                $subtotal = $d['cantidad'] * $d['precio_unitario'];
                $totalVenta += $subtotal;
                $pdf->Cell(70, 8, utf8_decode($d['producto']), 1);
                $pdf->Cell(30, 8, $d['cantidad'], 1, 0, 'C');
                $pdf->Cell(40, 8, number_format($d['precio_unitario'], 2), 1, 0, 'R');
                $pdf->Cell(40, 8, number_format($subtotal, 2), 1, 1, 'R');
            }

            // 🔹 Total por venta
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(140, 8, 'TOTAL VENTA:', 1, 0, 'R');
            $pdf->Cell(40, 8, number_format($totalVenta, 2), 1, 1, 'R');
            $pdf->Ln(8);

            $totalGeneral += $totalVenta;
        }

        // 🔹 Total general al final
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell(140, 10, 'TOTAL GENERAL DE TODAS LAS VENTAS:', 1, 0, 'R');
        $pdf->Cell(40, 10, number_format($totalGeneral, 2), 1, 1, 'R');

        $pdf->exportar('reporte_ventas_completas.pdf');
    }


    public function productosStockMinimo($limite = 5)
    {
        $productoModel = new Producto();
        $productos = $productoModel->getProductosStockMinimo($limite);

        $pdf = new ReportePDF();
        $pdf->AddPage();

        $cabeceras = ['ID', 'Nombre', 'Stock', 'Precio (Bs)', 'Categoría'];
        $datos = [];
        foreach ($productos as $p) {
            $datos[] = [
                $p['id_producto'],
                $p['nombre'],
                $p['stock'],
                number_format($p['precio'], 2),
                $p['tipo_producto']
            ];
        }

        $pdf->generarTabla($cabeceras, $datos, [10, 60, 20, 30, 40]);
        $pdf->exportar('reporte_stock_minimo.pdf');
    }

    public function ventasDelDia()
    {
        $ventaModel = new Venta();
        $ventas = $ventaModel->getVentasDelDia();

        $totalRecaudado = array_sum(array_column($ventas, 'total'));

        $pdf = new ReportePDF();
        $pdf->AddPage();

        $cabeceras = ['ID', 'Usuario', 'Cliente', 'Fecha', 'Total (Bs)'];
        $datos = [];
        foreach ($ventas as $v) {
            $datos[] = [
                $v['id_venta'],
                trim($v['usuario_nombre'] . ' ' . $v['usuario_apellido_paterno']),
                trim($v['cliente_nombre'] . ' ' . $v['cliente_apellido_paterno']),
                $v['fecha'],
                number_format($v['total'], 2)
            ];
        }

        $pdf->generarTabla($cabeceras, $datos, [10, 50, 50, 40, 30]);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Total recaudado hoy: Bs. ' . number_format($totalRecaudado, 2), 0, 1, 'R');

        $pdf->exportar('reporte_ventas_dia.pdf');
    }

    public function clientesMasCompras($top = 5)
    {
        $clienteModel = new Cliente();
        $clientes = $clienteModel->getClientesMasCompras($top);

        $pdf = new ReportePDF();
        $pdf->AddPage();

        $cabeceras = ['ID Cliente', 'Nombre', 'Total Compras'];
        $datos = [];
        foreach ($clientes as $c) {
            $datos[] = [
                $c['id_cliente'],
                trim($c['nombre'] . ' ' . $c['apellido_paterno']),
                $c['total_compras']
            ];
        }

        $pdf->generarTabla($cabeceras, $datos, [20, 80, 40]);
        $pdf->exportar('reporte_clientes_top.pdf');
    }
}
