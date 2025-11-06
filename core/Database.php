<?php
// core/Database.php
require_once __DIR__ . '/../configuracion/basedatos.php';

class CoreDatabase {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
}