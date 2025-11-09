<?php
// modelo/Carrito.php

class Carrito {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    public function agregarProducto($producto, $cantidad = 1) {
        $id = $producto['id_producto'];

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
        } else {
            $_SESSION['carrito'][$id] = [
                'id_producto' => $id,
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio_venta'],
                'imagen' => $producto['imagen'],
                'stock' => $producto['stock'],
                'cantidad' => $cantidad
            ];
        }
    }

    public function eliminarProducto($id) {
        if (isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }
    }

    public function vaciar() {
        $_SESSION['carrito'] = [];
    }

    public function obtenerProductos() {
        return $_SESSION['carrito'];
    }

    public function obtenerTotal() {
        $total = 0;
        foreach ($_SESSION['carrito'] as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        return $total;
    }
}
