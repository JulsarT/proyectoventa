<?php
// controlador/ProveedorController.php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../modelo/Proveedor.php';

class ProveedorController extends Controller {
    private $proveedorModel;

    public function __construct() {
        $this->proveedorModel = new Proveedor();
    }

    public function index() {
        $this->requireAuth(); // Cualquier usuario autenticado puede ver
        $data['proveedores'] = $this->proveedorModel->getAll();
        $data['title'] = 'Lista de Proveedores';
        $this->view('proveedor.index', $data);
    }

    public function crear() {
        $this->requireAuth(); // Cualquier autenticado puede crear (ajusta si solo admin)
        $data['title'] = 'Crear Proveedor';
        $this->view('proveedor.crear', $data);
    }

    public function guardar() {
        $this->requireAuth(); // Cualquier autenticado puede guardar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'razon_social' => filter_input(INPUT_POST, 'razon_social', FILTER_SANITIZE_STRING),
                'nit' => filter_input(INPUT_POST, 'nit', FILTER_SANITIZE_STRING),
                'contacto' => filter_input(INPUT_POST, 'contacto', FILTER_SANITIZE_STRING),
                'telefono' => filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING),
                'direccion' => filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING)
            ];

            if ($this->proveedorModel->create($data)) {
                $this->redirect('proveedor');
            } else {
                $data['error'] = 'Error al crear el proveedor';
                $this->view('proveedor.crear', $data);
            }
        }
    }

    public function editar($id) {
        $this->requireAuth('administrador'); // Solo admin puede editar
        $data['proveedor'] = $this->proveedorModel->getById($id);
        $data['title'] = 'Editar Proveedor';
        if ($data['proveedor']) {
            $this->view('proveedor.editar', $data);
        } else {
            $this->redirect('proveedor');
        }
    }

    public function actualizar($id) {
        $this->requireAuth('administrador'); // Solo admin puede actualizar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'razon_social' => filter_input(INPUT_POST, 'razon_social', FILTER_SANITIZE_STRING),
                'nit' => filter_input(INPUT_POST, 'nit', FILTER_SANITIZE_STRING),
                'contacto' => filter_input(INPUT_POST, 'contacto', FILTER_SANITIZE_STRING),
                'telefono' => filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING),
                'direccion' => filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING)
            ];

            if ($this->proveedorModel->update($id, $data)) {
                $this->redirect('proveedor');
            } else {
                $data['error'] = 'Error al actualizar el proveedor';
                $data['proveedor'] = $this->proveedorModel->getById($id);
                $this->view('proveedor.editar', $data);
            }
        }
    }
    public function generarPDF() {
        $this->requireAuth();
        $proveedores = $this->proveedorModel->getAll();
        require_once __DIR__ . '/../vendor/pdf/proveedorPdf.php';
        $pdf = new ProveedorPDF($proveedores);
        $pdf->generate();
    }
    public function eliminar($id) {
        $this->requireAuth('administrador'); // Solo admin puede eliminar
        if ($this->proveedorModel->delete($id)) {
            $this->redirect('proveedor');
        } else {
            $this->redirect('proveedor');
        }
    }
}