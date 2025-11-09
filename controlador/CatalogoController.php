<?php
// controlador/CatalogoController.php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../modelo/Producto.php';
require_once __DIR__ . '/../modelo/Carrito.php';

class CatalogoController extends Controller
{
    private $productoModel;
    private $carrito;

    public function __construct()
    {
        $this->productoModel = new Producto();
        $this->carrito = new Carrito();
    }

    public function index()
    {
        $categoria = $_GET['categoria'] ?? null;
        $ordenPrecio = $_GET['orden_precio'] ?? null;
        $ordenStock = $_GET['orden_stock'] ?? null;

        $productos = $this->productoModel->getFiltradosConMargen($categoria, $ordenPrecio, $ordenStock);
        $productosBajos = $this->productoModel->getProductosConStockBajo(5);

        $data = [
            'title' => 'Catálogo de Productos',
            'productos' => $productos,
            'productosBajos' => $productosBajos,
            'categoria' => $categoria,
            'orden_precio' => $ordenPrecio,
            'orden_stock' => $ordenStock
        ];

        $this->view('catalogo/index', $data);
    }

    public function agregar($id)
    {
        $producto = $this->productoModel->getByIdConMargen($id);
        if ($producto) {
            $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;
            $this->carrito->agregarProducto($producto, $cantidad);
        }
        $this->redirect('catalogo', 'index');
    }

    public function eliminar($id)
    {
        $this->carrito->eliminarProducto($id);
        $this->redirect('catalogo', 'carrito');
    }

    public function vaciar()
    {
        $this->carrito->vaciar();
        $this->redirect('catalogo', 'carrito');
    }

    // Mostrar carrito de compras - ACTUALIZADO
    public function carrito()
    {
        require_once __DIR__ . '/../modelo/Cliente.php';
        $clienteModel = new Cliente();

        // 🔹 CAMBIO: Traer TODOS los clientes automáticamente
        $clientes = $clienteModel->getAll();

        $data = [
            'title' => 'Carrito de Compras',
            'clientes' => $clientes
        ];
        
        $this->view('catalogo/carrito', $data);
    }

    // Procesar venta
    public function procesarVenta()
    {
        session_start();
        if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
            $_SESSION['msg'] = "El carrito está vacío.";
            header('Location: ' . BASE_URL . 'catalogo/carrito');
            exit;
        }

        // Validar cliente
        $id_cliente = isset($_POST['id_cliente']) ? intval($_POST['id_cliente']) : null;
        if (!$id_cliente) {
            $_SESSION['msg'] = "Debe seleccionar un cliente.";
            header('Location: ' . BASE_URL . 'catalogo/carrito');
            exit;
        }

        $id_usuario = $_SESSION['usuario']['id_usuario'] ?? 1;

        require_once __DIR__ . '/../modelo/Venta.php';
        $ventaModel = new Venta();

        $detalles = [];
        $total = 0;
        foreach ($_SESSION['carrito'] as $item) {
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
            $detalles[] = [
                'id_producto' => $item['id_producto'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio']
            ];
        }

        // Crear venta
        $data = [
            'id_usuario' => $id_usuario,
            'id_cliente' => $id_cliente,
            'total' => $total
        ];

        $id_venta = $ventaModel->create($data, $detalles);

        if ($id_venta) {
            unset($_SESSION['carrito']);
            $_SESSION['msg'] = "Venta procesada correctamente (ID #$id_venta)";
            header('Location: ' . BASE_URL . 'venta');
        } else {
            $_SESSION['msg'] = "Error al procesar la venta.";
            header('Location: ' . BASE_URL . 'catalogo/carrito');
        }
    }
}