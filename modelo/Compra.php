<?php
// modelo/Compra.php
require_once __DIR__ . '/../core/Database.php';

class Compra extends CoreDatabase {
    public function getAll() {
        $query = "SELECT c.*, u.nombre, u.apellido_paterno, u.apellido_materno, p.razon_social AS proveedor_nombre
                    FROM compras c
                    JOIN usuarios u ON c.id_usuario = u.id_usuario
                    JOIN proveedores p ON c.id_proveedor = p.id_proveedor";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $query = "SELECT c.*, 
              CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) AS usuario_nombre, 
              p.razon_social AS proveedor_nombre
              FROM compras c
              JOIN usuarios u ON c.id_usuario = u.id_usuario
              JOIN proveedores p ON c.id_proveedor = p.id_proveedor
              WHERE c.id_compra = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getDetallesByCompraId($id_compra) {
        $query = "SELECT dc.*, p.nombre AS producto_nombre 
                  FROM detalle_compra dc 
                  LEFT JOIN productos p ON dc.id_producto = p.id_producto 
                  WHERE dc.id_compra = :id_compra";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($data, $detalles) {
        try {
            $this->db->beginTransaction();

            // Crear la compra
            $query = "INSERT INTO compras (id_usuario, id_proveedor, fecha, total) 
                      VALUES (:id_usuario, :id_proveedor, NOW(), :total)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_usuario', $data['id_usuario'], PDO::PARAM_INT);
            $stmt->bindParam(':id_proveedor', $data['id_proveedor'], PDO::PARAM_INT);
            $stmt->bindParam(':total', $data['total']);
            $stmt->execute();
            $id_compra = $this->db->lastInsertId();

            // Insertar detalles y actualizar stock
            foreach ($detalles as $detalle) {
                // Insertar detalle
                $query_detalle = "INSERT INTO detalle_compra (id_compra, id_producto, cantidad, precio_unitario) 
                                  VALUES (:id_compra, :id_producto, :cantidad, :precio_unitario)";
                $stmt_detalle = $this->db->prepare($query_detalle);
                $stmt_detalle->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
                $stmt_detalle->bindParam(':id_producto', $detalle['id_producto'], PDO::PARAM_INT);
                $stmt_detalle->bindParam(':cantidad', $detalle['cantidad'], PDO::PARAM_INT);
                $stmt_detalle->bindParam(':precio_unitario', $detalle['precio_unitario']);
                $stmt_detalle->execute();

                // Actualizar stock
                $query_stock = "UPDATE productos SET stock = stock + :cantidad WHERE id_producto = :id_producto";
                $stmt_stock = $this->db->prepare($query_stock);
                $stmt_stock->bindParam(':cantidad', $detalle['cantidad'], PDO::PARAM_INT);
                $stmt_stock->bindParam(':id_producto', $detalle['id_producto'], PDO::PARAM_INT);
                $stmt_stock->execute();
            }

            $this->db->commit();
            return $id_compra;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function delete($id) {
        try {
            $this->db->beginTransaction();

            // Obtener detalles para reducir stock
            $detalles = $this->getDetallesByCompraId($id);
            foreach ($detalles as $detalle) {
                $query_stock = "UPDATE productos SET stock = stock - :cantidad WHERE id_producto = :id_producto";
                $stmt_stock = $this->db->prepare($query_stock);
                $stmt_stock->bindParam(':cantidad', $detalle['cantidad'], PDO::PARAM_INT);
                $stmt_stock->bindParam(':id_producto', $detalle['id_producto'], PDO::PARAM_INT);
                $stmt_stock->execute();
            }

            // Eliminar detalles
            $query_detalle = "DELETE FROM detalle_compra WHERE id_compra = :id";
            $stmt_detalle = $this->db->prepare($query_detalle);
            $stmt_detalle->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_detalle->execute();

            // Eliminar compra
            $query = "DELETE FROM compras WHERE id_compra = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getUsuarios() {
        $query = "SELECT id_usuario, nombre FROM usuarios WHERE estado = 'activo'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProveedores() {
        $query = "SELECT id_proveedor, razon_social FROM proveedores";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // public function getProductos() {
    //     $query = "SELECT id_producto, nombre, precio FROM productos";
    //     $stmt = $this->db->prepare($query);
    //     $stmt->execute();
    //     return $stmt->fetchAll();
    // }
    // modelo/Compra.php
    public function getProductos() {
        // MODIFICA ESTA LÍNEA
        $query = "SELECT id_producto, nombre, precio, stock FROM productos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}