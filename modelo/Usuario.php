<?php
// modelo/Usuario.php
require_once __DIR__ . '/../core/Database.php';

class Usuario extends CoreDatabase {
    public function getAll($includeInactive = false) {
        $query = "SELECT * FROM usuarios";
        if ($includeInactive) {
            $query .= " WHERE estado = 'inactivo'";
        } else {
            $query .= " WHERE estado = 'activo'";
        }
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $query = "SELECT * FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($data) {
        $query = "INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, email, password, tipo_usuario, estado) 
                  VALUES (:nombre, :apellido_paterno, :apellido_materno, :email, :password, :tipo_usuario, 'activo')";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido_paterno', $data['apellido_paterno']);
        $stmt->bindParam(':apellido_materno', $data['apellido_materno']);
        $stmt->bindParam(':email', $data['email']);
        $password = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':tipo_usuario', $data['tipo_usuario']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE usuarios SET 
                  nombre = :nombre, 
                  apellido_paterno = :apellido_paterno, 
                  apellido_materno = :apellido_materno, 
                  email = :email, 
                  tipo_usuario = :tipo_usuario";
        if (!empty($data['password'])) {
            $query .= ", password = :password";
        }
        $query .= " WHERE id_usuario = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido_paterno', $data['apellido_paterno']);
        $stmt->bindParam(':apellido_materno', $data['apellido_materno']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':tipo_usuario', $data['tipo_usuario']);
        if (!empty($data['password'])) {
            $password = password_hash($data['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password);
        }
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function setInactive($id) {
        $query = "UPDATE usuarios SET estado = 'inactivo' WHERE id_usuario = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function setActive($id) {
        $query = "UPDATE usuarios SET estado = 'activo' WHERE id_usuario = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function delete($id) {
        $query = "DELETE FROM usuarios WHERE id_usuario = :id AND estado = 'inactivo'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function login($email, $password) {
        $query = "SELECT * FROM usuarios WHERE email = :email AND estado = 'activo'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}