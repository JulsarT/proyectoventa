<?php
// modelo/Venta.php
require_once __DIR__ . '/../core/Database.php';

class Venta extends CoreDatabase
{
    public function getAll()
    {
        $query = "SELECT 
                    v.*, 
                    u.nombre AS usuario_nombre, u.apellido_paterno AS usuario_apellido_paterno, u.apellido_materno AS usuario_apellido_materno,
                    c.nombre AS cliente_nombre, c.apellido_paterno AS cliente_apellido_paterno, c.apellido_materno AS cliente_apellido_materno
                FROM ventas v 
                LEFT JOIN usuarios u ON v.id_usuario = u.id_usuario 
                LEFT JOIN clientes c ON v.id_cliente = c.id_cliente";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getById($id)
    {
        $query = "SELECT 
                    v.*, 
                    u.nombre AS usuario_nombre, u.apellido_paterno AS usuario_apellido_paterno, u.apellido_materno AS usuario_apellido_materno,
                    c.nombre AS cliente_nombre, c.apellido_paterno AS cliente_apellido_paterno, c.apellido_materno AS cliente_apellido_materno
                FROM ventas v 
                LEFT JOIN usuarios u ON v.id_usuario = u.id_usuario 
                LEFT JOIN clientes c ON v.id_cliente = c.id_cliente 
                WHERE v.id_venta = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }


    public function getDetallesByVentaId($id_venta)
    {
        $query = "SELECT dv.*, p.nombre AS producto_nombre 
                  FROM detalle_venta dv 
                  LEFT JOIN productos p ON dv.id_producto = p.id_producto 
                  WHERE dv.id_venta = :id_venta";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_venta', $id_venta, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($data, $detalles)
    {
        try {
            $this->db->beginTransaction();

            // Crear la venta
            $query = "INSERT INTO ventas (id_usuario, id_cliente, fecha, total) 
                      VALUES (:id_usuario, :id_cliente, NOW(), :total)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_usuario', $data['id_usuario'], PDO::PARAM_INT);
            $stmt->bindParam(':id_cliente', $data['id_cliente'], PDO::PARAM_INT);
            $stmt->bindParam(':total', $data['total']);
            $stmt->execute();
            $id_venta = $this->db->lastInsertId();

            // Insertar detalles y actualizar stock
            foreach ($detalles as $detalle) {
                // Insertar detalle
                $query_detalle = "INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio_unitario) 
                                  VALUES (:id_venta, :id_producto, :cantidad, :precio_unitario)";
                $stmt_detalle = $this->db->prepare($query_detalle);
                $stmt_detalle->bindParam(':id_venta', $id_venta, PDO::PARAM_INT);
                $stmt_detalle->bindParam(':id_producto', $detalle['id_producto'], PDO::PARAM_INT);
                $stmt_detalle->bindParam(':cantidad', $detalle['cantidad'], PDO::PARAM_INT);
                $stmt_detalle->bindParam(':precio_unitario', $detalle['precio_unitario']);
                $stmt_detalle->execute();

                // Actualizar stock
                $query_stock = "UPDATE productos SET stock = stock - :cantidad WHERE id_producto = :id_producto";
                $stmt_stock = $this->db->prepare($query_stock);
                $stmt_stock->bindParam(':cantidad', $detalle['cantidad'], PDO::PARAM_INT);
                $stmt_stock->bindParam(':id_producto', $detalle['id_producto'], PDO::PARAM_INT);
                $stmt_stock->execute();
            }

            $this->db->commit();
            return $id_venta;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $this->db->beginTransaction();

            // Obtener detalles para restaurar stock
            $detalles = $this->getDetallesByVentaId($id);
            foreach ($detalles as $detalle) {
                $query_stock = "UPDATE productos SET stock = stock + :cantidad WHERE id_producto = :id_producto";
                $stmt_stock = $this->db->prepare($query_stock);
                $stmt_stock->bindParam(':cantidad', $detalle['cantidad'], PDO::PARAM_INT);
                $stmt_stock->bindParam(':id_producto', $detalle['id_producto'], PDO::PARAM_INT);
                $stmt_stock->execute();
            }

            // Eliminar detalles
            $query_detalle = "DELETE FROM detalle_venta WHERE id_venta = :id";
            $stmt_detalle = $this->db->prepare($query_detalle);
            $stmt_detalle->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_detalle->execute();

            // Eliminar venta
            $query = "DELETE FROM ventas WHERE id_venta = :id";
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

    public function getUsuarios()
    {
        $query = "SELECT id_usuario, nombre FROM usuarios WHERE estado = 'activo'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getClientes()
    {
        $query = "SELECT id_cliente, nombre FROM clientes";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /*public function getProductos()
    {
        $query = "SELECT id_producto, nombre, precio, stock FROM productos WHERE stock > 0";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }*/
    //con precio de venta
    public function getProductos()
    {
        $query = "SELECT id_producto, nombre, precio, stock, 
              ROUND(precio * 1.30, 2) AS precio_venta
              FROM productos WHERE stock > 0";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getAllVentasConUsuarioCliente()
    {
        $query = "SELECT v.*, u.nombre as usuario_nombre, u.apellido_paterno as usuario_apellido_paterno,
              c.nombre as cliente_nombre, c.apellido_paterno as cliente_apellido_paterno
              FROM ventas v
              LEFT JOIN usuarios u ON v.id_usuario = u.id_usuario
              LEFT JOIN clientes c ON v.id_cliente = c.id_cliente
              ORDER BY v.fecha DESC";
        return $this->db->query($query)->fetchAll();
    }

    public function getVentasDelDia()
    {
        $hoy = date('Y-m-d');
        $query = "SELECT v.*, u.nombre as usuario_nombre, u.apellido_paterno as usuario_apellido_paterno,
              c.nombre as cliente_nombre, c.apellido_paterno as cliente_apellido_paterno
              FROM ventas v
              LEFT JOIN usuarios u ON v.id_usuario = u.id_usuario
              LEFT JOIN clientes c ON v.id_cliente = c.id_cliente
              WHERE DATE(v.fecha) = :hoy
              ORDER BY v.fecha DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':hoy', $hoy);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
