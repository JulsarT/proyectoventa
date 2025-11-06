<?php
// controlador/ProductoController.php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../modelo/Producto.php';

class ProductoController extends Controller {
    private $productoModel;

    public function __construct() {
        $this->productoModel = new Producto();
    }

    public function index() {
        $this->requireAuth(); // Cualquier usuario autenticado puede ver
        $data['productos'] = $this->productoModel->getAll();
        $data['estadisticas'] = $this->productoModel->getEstadisticasPorTipo();
        $data['title'] = 'Lista de Productos';
        $data['mostrar_tipo'] = 'todos'; // Para controlar qué columnas mostrar
        $this->view('producto.index', $data);
    }

    // Método para mostrar solo accesorios
    public function accesorios() {
        $this->requireAuth();
        $data['productos'] = $this->productoModel->getAccesorios();
        $data['estadisticas'] = $this->productoModel->getEstadisticasPorTipo();
        $data['title'] = 'Accesorios';
        $data['mostrar_tipo'] = 'accesorio'; // Para mostrar columnas específicas de accesorio
        $this->view('producto.index', $data);
    }

    // Método para mostrar solo periféricos
    public function perifericos() {
        $this->requireAuth();
        $data['productos'] = $this->productoModel->getPerifericos();
        $data['estadisticas'] = $this->productoModel->getEstadisticasPorTipo();
        $data['title'] = 'Periféricos';
        $data['mostrar_tipo'] = 'periferico'; // Para mostrar columnas específicas de periférico
        $this->view('producto.index', $data);
    }

    public function crear() {
        $this->requireAuth(); // Cualquier autenticado puede crear (ajusta si solo admin)
        $data['proveedores'] = $this->productoModel->getProveedores();
        $data['title'] = 'Crear Producto';
        $this->view('producto.crear', $data);
    }

    public function guardar() {
        $this->requireAuth(); // Cualquier autenticado puede guardar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING),
                'descripcion' => filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING),
                'precio' => filter_input(INPUT_POST, 'precio', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'stock' => filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT),
                'id_proveedor' => filter_input(INPUT_POST, 'id_proveedor', FILTER_SANITIZE_NUMBER_INT),
                'tipo_producto' => filter_input(INPUT_POST, 'tipo_producto', FILTER_SANITIZE_STRING)
            ];

            // Agregar campos específicos según el tipo
            if ($data['tipo_producto'] === 'accesorio') {
                $data['material'] = filter_input(INPUT_POST, 'material', FILTER_SANITIZE_STRING);
                $data['color'] = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
                $data['compatibilidad'] = filter_input(INPUT_POST, 'compatibilidad', FILTER_SANITIZE_STRING);
            } elseif ($data['tipo_producto'] === 'periferico') {
                $data['tipo_conexion'] = filter_input(INPUT_POST, 'tipo_conexion', FILTER_SANITIZE_STRING);
                $data['marca'] = filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_STRING);
                $data['garantia_meses'] = filter_input(INPUT_POST, 'garantia_meses', FILTER_SANITIZE_NUMBER_INT);
            }

            $imagePath = null;
            if (!empty($_FILES['imagen']['name'])) {
                $uploadDir = __DIR__ . '/../uploads/';
                $imageName = uniqid() . '_' . basename($_FILES['imagen']['name']);
                $imagePath = 'uploads/' . $imageName;
                if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $imageName)) {
                    $data['error'] = 'Error al subir la imagen';
                    $data['proveedores'] = $this->productoModel->getProveedores();
                    $this->view('producto.crear', $data);
                    return;
                }
            }

            if ($this->productoModel->create($data, $imagePath)) {
                $this->redirect('producto');
            } else {
                $data['error'] = 'Error al crear el producto';
                $data['proveedores'] = $this->productoModel->getProveedores();
                $this->view('producto.crear', $data);
            }
        }
    }

    public function editar($id) {
        $this->requireAuth('administrador'); // Solo admin puede editar
        $data['producto'] = $this->productoModel->getById($id);
        $data['proveedores'] = $this->productoModel->getProveedores();
        $data['title'] = 'Editar Producto';
        if ($data['producto']) {
            $this->view('producto.editar', $data);
        } else {
            $this->redirect('producto');
        }
    }

    public function actualizar($id) {
        $this->requireAuth('administrador'); // Solo admin puede actualizar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING),
                'descripcion' => filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING),
                'precio' => filter_input(INPUT_POST, 'precio', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'stock' => filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT),
                'id_proveedor' => filter_input(INPUT_POST, 'id_proveedor', FILTER_SANITIZE_NUMBER_INT),
                'tipo_producto' => filter_input(INPUT_POST, 'tipo_producto', FILTER_SANITIZE_STRING)
            ];

            // Agregar campos específicos según el tipo
            if ($data['tipo_producto'] === 'accesorio') {
                $data['material'] = filter_input(INPUT_POST, 'material', FILTER_SANITIZE_STRING);
                $data['color'] = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
                $data['compatibilidad'] = filter_input(INPUT_POST, 'compatibilidad', FILTER_SANITIZE_STRING);
            } elseif ($data['tipo_producto'] === 'periferico') {
                $data['tipo_conexion'] = filter_input(INPUT_POST, 'tipo_conexion', FILTER_SANITIZE_STRING);
                $data['marca'] = filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_STRING);
                $data['garantia_meses'] = filter_input(INPUT_POST, 'garantia_meses', FILTER_SANITIZE_NUMBER_INT);
            }

            $imagePath = null;
            if (!empty($_FILES['imagen']['name'])) {
                $uploadDir = __DIR__ . '/../uploads/';
                $imageName = uniqid() . '_' . basename($_FILES['imagen']['name']);
                $imagePath = 'uploads/' . $imageName;
                if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $imageName)) {
                    $data['error'] = 'Error al subir la imagen';
                    $data['producto'] = $this->productoModel->getById($id);
                    $data['proveedores'] = $this->productoModel->getProveedores();
                    $this->view('producto.editar', $data);
                    return;
                }
            }

            if ($this->productoModel->update($id, $data, $imagePath)) {
                $this->redirect('producto');
            } else {
                $data['error'] = 'Error al actualizar el producto';
                $data['producto'] = $this->productoModel->getById($id);
                $data['proveedores'] = $this->productoModel->getProveedores();
                $this->view('producto.editar', $data);
            }
        }
    }

    public function generarPDF() {
        $this->requireAuth();
        $productos = $this->productoModel->getAll();
        require_once __DIR__ . '/../vendor/pdf/productoPdf.php';
        $pdf = new ProductoPDF($productos);
        $pdf->generate();
    }

    public function eliminar($id) {
        $this->requireAuth('administrador'); // Solo admin puede eliminar
        if ($this->productoModel->delete($id)) {
            $this->redirect('producto');
        } else {
            $this->redirect('producto');
        }
    }
}