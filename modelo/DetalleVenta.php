<?php
// modelo/DetalleVenta.php
require_once __DIR__ . '/../core/Database.php';

class DetalleVenta extends CoreDatabase {
    public function getByVentaId($id_venta) {
        $query = "SELECT dv.*, p.nombre AS producto_nombre 
                  FROM detalle_venta dv 
                  LEFT JOIN productos p ON dv.id_producto = p.id_producto 
                  WHERE dv.id_venta = :id_venta";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_venta', $id_venta, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}