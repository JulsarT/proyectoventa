<?php
// controlador/CompraController.php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../modelo/Compra.php';

class CompraController extends Controller {
    private $compraModel;

    public function __construct() {
        $this->compraModel = new Compra();
    }

    public function index() {
        $data['compras'] = $this->compraModel->getAll();
        $data['title'] = 'Lista de Compras';
        $this->view('compra.index', $data);
    }

    public function crear() {
        $data['usuarios'] = $this->compraModel->getUsuarios();
        $data['proveedores'] = $this->compraModel->getProveedores();
        $data['productos'] = $this->compraModel->getProductos();
        $data['title'] = 'Crear Compra';
        $this->view('compra.crear', $data);
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_usuario' => filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_NUMBER_INT),
                'id_proveedor' => filter_input(INPUT_POST, 'id_proveedor', FILTER_SANITIZE_NUMBER_INT),
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

            if ($this->compraModel->create($data, $detalles)) {
                $this->redirect('compra');
            } else {
                $data['error'] = 'Error al crear la compra';
                $data['usuarios'] = $this->compraModel->getUsuarios();
                $data['proveedores'] = $this->compraModel->getProveedores();
                $data['productos'] = $this->compraModel->getProductos();
                $this->view('compra.crear', $data);
            }
        }
    }

    public function detalle($id) {
        $data['compra'] = $this->compraModel->getById($id);
        $data['detalles'] = $this->compraModel->getDetallesByCompraId($id);
        $data['title'] = 'Detalle de Compra';
        if ($data['compra']) {
            $this->view('compra.detalle', $data);
        } else {
            $this->redirect('compra');
        }
    }
    public function generarPDF() {
        $this->requireAuth();
        $compras = $this->compraModel->getAll();
        require_once __DIR__ . '/../vendor/pdf/compraPdf.php';
        $pdf = new CompraPDF($compras);
        $pdf->generate();
    }
    public function eliminar($id) {
        if ($this->compraModel->delete($id)) {
            $this->redirect('compra');
        } else {
            $this->redirect('compra');
        }
    }
}