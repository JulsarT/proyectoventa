<?php
// modelo/Proveedor.php
require_once __DIR__ . '/../core/Database.php';

class Proveedor extends CoreDatabase {
    public function getAll() {
        $query = "SELECT * FROM proveedores";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $query = "SELECT * FROM proveedores WHERE id_proveedor = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($data) {
        $query = "INSERT INTO proveedores (razon_social, nit, contacto, telefono, direccion) 
                  VALUES (:razon_social, :nit, :contacto, :telefono, :direccion)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':razon_social', $data['razon_social']);
        $stmt->bindParam(':nit', $data['nit']);
        $stmt->bindParam(':contacto', $data['contacto']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':direccion', $data['direccion']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE proveedores SET 
                  razon_social = :razon_social, 
                  nit = :nit, 
                  contacto = :contacto, 
                  telefono = :telefono, 
                  direccion = :direccion 
                  WHERE id_proveedor = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':razon_social', $data['razon_social']);
        $stmt->bindParam(':nit', $data['nit']);
        $stmt->bindParam(':contacto', $data['contacto']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM proveedores WHERE id_proveedor = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}