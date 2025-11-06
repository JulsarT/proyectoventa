<?php
// configuracion/basedatos.php

class Database {
    private $host = 'localhost';
    private $db_name = 'venta_accesorios2';
    private $username = 'root'; // Cambia esto según tu configuración
    private $password = '69768248'; // Cambia esto según tu configuración
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit;
        }
        return $this->conn;
    }
}