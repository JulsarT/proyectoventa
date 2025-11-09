<?php
// modelo/Cliente.php
require_once __DIR__ . '/../core/Database.php';

class Cliente extends CoreDatabase
{
    public function getAll()
    {
        $query = "SELECT * FROM clientes";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $query = "SELECT * FROM clientes WHERE id_cliente = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($data)
    {
        $query = "INSERT INTO clientes (nombre, apellido_paterno, apellido_materno, telefono, email, direccion) 
                  VALUES (:nombre, :apellido_paterno, :apellido_materno, :telefono, :email, :direccion)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido_paterno', $data['apellido_paterno']);
        $stmt->bindParam(':apellido_materno', $data['apellido_materno']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':direccion', $data['direccion']);
        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $query = "UPDATE clientes SET 
                  nombre = :nombre, 
                  apellido_paterno = :apellido_paterno, 
                  apellido_materno = :apellido_materno, 
                  telefono = :telefono, 
                  email = :email, 
                  direccion = :direccion 
                  WHERE id_cliente = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido_paterno', $data['apellido_paterno']);
        $stmt->bindParam(':apellido_materno', $data['apellido_materno']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $query = "DELETE FROM clientes WHERE id_cliente = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function buscarPorNombre($nombre)
    {
        $query = "SELECT * FROM clientes WHERE nombre LIKE :nombre";
        $stmt = $this->db->prepare($query);
        $like = "%$nombre%";
        $stmt->bindParam(':nombre', $like);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getClientesMasCompras($top = 5)
    {
        $query = "SELECT c.*, COUNT(v.id_venta) as total_compras
              FROM clientes c
              LEFT JOIN ventas v ON c.id_cliente = v.id_cliente
              GROUP BY c.id_cliente
              ORDER BY total_compras DESC
              LIMIT :top";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':top', $top, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
