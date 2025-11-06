<?php
// controlador/VentaController.php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../modelo/Venta.php';

class VentaController extends Controller {
    private $ventaModel;

    public function __construct() {
        $this->ventaModel = new Venta();
    }

    public function index() {
        $data['ventas'] = $this->ventaModel->getAll();
        $data['title'] = 'Lista de Ventas';
        $this->view('venta.index', $data);
    }

    public function crear() {
        $data['usuarios'] = $this->ventaModel->getUsuarios();
        $data['clientes'] = $this->ventaModel->getClientes();
        $data['productos'] = $this->ventaModel->getProductos();
        $data['title'] = 'Crear Venta';
        $this->view('venta.crear', $data);
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_usuario' => filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_NUMBER_INT),
                'id_cliente' => filter_input(INPUT_POST, 'id_cliente', FILTER_SANITIZE_NUMBER_INT),
                'total' => filter_input(INPUT_POST, 'total', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)
            ];

            $detalles = [];
            $id_productos = $_POST['id_producto'] ?? [];
            $cantidades = $_POST['cantidad'] ?? [];
            $precios = $_POST['precio_unitario'] ?? [];

            for ($i = 0; $i < count($id_productos); $i++) {
                $detalles[] = [
                    'id_producto' => filter_var($id_productos[$i], FILTER_SANITIZE_NUMBER_INT),
                    'cantidad' => filter_var($cantidades[$i], FILTER_SANITIZE_NUMBER_INT),
                    'precio_unitario' => filter_var($precios[$i], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)
                ];
            }

            if ($this->ventaModel->create($data, $detalles)) {
                $this->redirect('venta');
            } else {
                $data['error'] = 'Error al crear la venta';
                $data['usuarios'] = $this->ventaModel->getUsuarios();
                $data['clientes'] = $this->ventaModel->getClientes();
                $data['productos'] = $this->ventaModel->getProductos();
                $this->view('venta.crear', $data);
            }
        }
    }

    public function detalle($id) {
        $data['venta'] = $this->ventaModel->getById($id);
        $data['detalles'] = $this->ventaModel->getDetallesByVentaId($id);
        $data['title'] = 'Detalle de Venta';
        if ($data['venta']) {
            $this->view('venta.detalle', $data);
        } else {
            $this->redirect('venta');
        }
    }
    public function generarPDF() {
        $this->requireAuth();
        $ventas = $this->ventaModel->getAll();
        require_once __DIR__ . '/../vendor/pdf/ventaPdf.php';
        $pdf = new VentaPDF($ventas);
        $pdf->generate();
    }
    public function eliminar($id) {
        if ($this->ventaModel->delete($id)) {
            $this->redirect('venta');
        } else {
            $this->redirect('venta');
        }
    }
}