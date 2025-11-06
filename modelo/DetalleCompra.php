<?php
// modelo/DetalleCompra.php
require_once __DIR__ . '/../core/Database.php';

class DetalleCompra extends CoreDatabase {
    public function getByCompraId($id_compra) {
        $query = "SELECT dc.*, p.nombre AS producto_nombre 
                  FROM detalle_compra dc 
                  LEFT JOIN productos p ON dc.id_producto = p.id_producto 
                  WHERE dc.id_compra = :id_compra";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_compra', $id_compra, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}