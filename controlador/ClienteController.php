<?php
// controlador/ClienteController.php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../modelo/Cliente.php';

class ClienteController extends Controller {
    private $clienteModel;

    public function __construct() {
        $this->clienteModel = new Cliente();
    }

    public function index() {
        $data['clientes'] = $this->clienteModel->getAll();
        $data['title'] = 'Lista de Clientes';
        $this->view('cliente.index', $data);
    }

    public function crear() {
        $data['title'] = 'Crear Cliente';
        $this->view('cliente.crear', $data);
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING),
                'apellido_paterno' => filter_input(INPUT_POST, 'apellido_paterno', FILTER_SANITIZE_STRING),
                'apellido_materno' => filter_input(INPUT_POST, 'apellido_materno', FILTER_SANITIZE_STRING),
                'telefono' => filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING),
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'direccion' => filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING)
            ];

            if ($this->clienteModel->create($data)) {
                $this->redirect('cliente');
            } else {
                $data['error'] = 'Error al crear el cliente';
                $this->view('cliente.crear', $data);
            }
        }
    }

    public function editar($id) {
        $data['cliente'] = $this->clienteModel->getById($id);
        $data['title'] = 'Editar Cliente';
        if ($data['cliente']) {
            $this->view('cliente.editar', $data);
        } else {
            $this->redirect('cliente');
        }
    }

    public function actualizar($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING),
                'apellido_paterno' => filter_input(INPUT_POST, 'apellido_paterno', FILTER_SANITIZE_STRING),
                'apellido_materno' => filter_input(INPUT_POST, 'apellido_materno', FILTER_SANITIZE_STRING),
                'telefono' => filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING),
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'direccion' => filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING)
            ];

            if ($this->clienteModel->update($id, $data)) {
                $this->redirect('cliente');
            } else {
                $data['error'] = 'Error al actualizar el cliente';
                $data['cliente'] = $this->clienteModel->getById($id);
                $this->view('cliente.editar', $data);
            }
        }
    }
    public function generarPDF() {
        $this->requireAuth();
        $clientes = $this->clienteModel->getAll();
        require_once __DIR__ . '/../vendor/pdf/clientePdf.php';
        $pdf = new ClientePDF($clientes);
        $pdf->generate();
    }
    public function eliminar($id) {
        if ($this->clienteModel->delete($id)) {
            $this->redirect('cliente');
        } else {
            $this->redirect('cliente');
        }
    }
}