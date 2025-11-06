<?php
// modelo/Producto.php
require_once __DIR__ . '/../core/Database.php';

class Producto extends CoreDatabase {
    
    // Obtener todos los productos con información de tipo
    public function getAll() {
        $query = "SELECT p.*, pr.razon_social,
                  CASE 
                    WHEN a.id_producto IS NOT NULL THEN 'accesorio'
                    WHEN pe.id_producto IS NOT NULL THEN 'periferico'
                    ELSE 'general'
                  END as tipo_producto
                  FROM productos p 
                  LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor
                  LEFT JOIN accesorio a ON p.id_producto = a.id_producto
                  LEFT JOIN periferico pe ON p.id_producto = pe.id_producto";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Obtener solo accesorios con sus atributos específicos
    public function getAccesorios() {
        $query = "SELECT p.*, pr.razon_social, a.material, a.color, a.compatibilidad,
                  'accesorio' as tipo_producto
                  FROM productos p 
                  LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor
                  INNER JOIN accesorio a ON p.id_producto = a.id_producto";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Obtener solo periféricos con sus atributos específicos
    public function getPerifericos() {
        $query = "SELECT p.*, pr.razon_social, pe.tipo_conexion, pe.marca, pe.garantia_meses,
                  'periferico' as tipo_producto
                  FROM productos p 
                  LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor
                  INNER JOIN periferico pe ON p.id_producto = pe.id_producto";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $query = "SELECT p.*, pr.razon_social,
                  a.material, a.color, a.compatibilidad,
                  pe.tipo_conexion, pe.marca, pe.garantia_meses,
                  CASE 
                    WHEN a.id_producto IS NOT NULL THEN 'accesorio'
                    WHEN pe.id_producto IS NOT NULL THEN 'periferico'
                    ELSE 'general'
                  END as tipo_producto
                  FROM productos p 
                  LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor
                  LEFT JOIN accesorio a ON p.id_producto = a.id_producto
                  LEFT JOIN periferico pe ON p.id_producto = pe.id_producto
                  WHERE p.id_producto = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($data, $imagePath = null) {
        try {
            $this->db->beginTransaction();
            
            // Insertar en tabla productos
            $query = "INSERT INTO productos (nombre, descripcion, precio, imagen, stock, id_proveedor) 
                      VALUES (:nombre, :descripcion, :precio, :imagen, :stock, :id_proveedor)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':descripcion', $data['descripcion']);
            $stmt->bindParam(':precio', $data['precio']);
            $stmt->bindParam(':imagen', $imagePath);
            $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
            $stmt->bindParam(':id_proveedor', $data['id_proveedor'], PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                throw new Exception("Error al insertar producto");
            }
            
            $productId = $this->db->lastInsertId();
            
            // Insertar en tabla específica según el tipo
            if ($data['tipo_producto'] === 'accesorio') {
                $queryAccesorio = "INSERT INTO accesorio (id_producto, material, color, compatibilidad) 
                                   VALUES (:id_producto, :material, :color, :compatibilidad)";
                $stmtAccesorio = $this->db->prepare($queryAccesorio);
                $stmtAccesorio->bindParam(':id_producto', $productId, PDO::PARAM_INT);
                $stmtAccesorio->bindParam(':material', $data['material']);
                $stmtAccesorio->bindParam(':color', $data['color']);
                $stmtAccesorio->bindParam(':compatibilidad', $data['compatibilidad']);
                
                if (!$stmtAccesorio->execute()) {
                    throw new Exception("Error al insertar accesorio");
                }
            } elseif ($data['tipo_producto'] === 'periferico') {
                $queryPeriferico = "INSERT INTO periferico (id_producto, tipo_conexion, marca, garantia_meses) 
                                    VALUES (:id_producto, :tipo_conexion, :marca, :garantia_meses)";
                $stmtPeriferico = $this->db->prepare($queryPeriferico);
                $stmtPeriferico->bindParam(':id_producto', $productId, PDO::PARAM_INT);
                $stmtPeriferico->bindParam(':tipo_conexion', $data['tipo_conexion']);
                $stmtPeriferico->bindParam(':marca', $data['marca']);
                $stmtPeriferico->bindParam(':garantia_meses', $data['garantia_meses'], PDO::PARAM_INT);
                
                if (!$stmtPeriferico->execute()) {
                    throw new Exception("Error al insertar periférico");
                }
            }
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function update($id, $data, $imagePath = null) {
        try {
            $this->db->beginTransaction();
            
            // Actualizar tabla productos
            $query = "UPDATE productos SET 
                      nombre = :nombre, 
                      descripcion = :descripcion, 
                      precio = :precio, 
                      stock = :stock, 
                      id_proveedor = :id_proveedor";
            if ($imagePath) {
                $query .= ", imagen = :imagen";
            }
            $query .= " WHERE id_producto = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':descripcion', $data['descripcion']);
            $stmt->bindParam(':precio', $data['precio']);
            $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
            $stmt->bindParam(':id_proveedor', $data['id_proveedor'], PDO::PARAM_INT);
            if ($imagePath) {
                $stmt->bindParam(':imagen', $imagePath);
            }
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                throw new Exception("Error al actualizar producto");
            }
            
            // Obtener tipo actual del producto
            $currentProduct = $this->getById($id);
            $currentType = $currentProduct['tipo_producto'];
            
            // Si cambió el tipo, eliminar registros anteriores
            if ($currentType !== $data['tipo_producto']) {
                if ($currentType === 'accesorio') {
                    $this->db->prepare("DELETE FROM accesorio WHERE id_producto = :id")->execute([':id' => $id]);
                } elseif ($currentType === 'periferico') {
                    $this->db->prepare("DELETE FROM periferico WHERE id_producto = :id")->execute([':id' => $id]);
                }
            }
            
            // Actualizar o insertar en tabla específica
            if ($data['tipo_producto'] === 'accesorio') {
                if ($currentType === 'accesorio') {
                    // Actualizar accesorio existente
                    $queryAccesorio = "UPDATE accesorio SET material = :material, color = :color, compatibilidad = :compatibilidad 
                                       WHERE id_producto = :id_producto";
                } else {
                    // Insertar nuevo accesorio
                    $queryAccesorio = "INSERT INTO accesorio (id_producto, material, color, compatibilidad) 
                                       VALUES (:id_producto, :material, :color, :compatibilidad)";
                }
                $stmtAccesorio = $this->db->prepare($queryAccesorio);
                $stmtAccesorio->bindParam(':id_producto', $id, PDO::PARAM_INT);
                $stmtAccesorio->bindParam(':material', $data['material']);
                $stmtAccesorio->bindParam(':color', $data['color']);
                $stmtAccesorio->bindParam(':compatibilidad', $data['compatibilidad']);
                
                if (!$stmtAccesorio->execute()) {
                    throw new Exception("Error al actualizar accesorio");
                }
                
            } elseif ($data['tipo_producto'] === 'periferico') {
                if ($currentType === 'periferico') {
                    // Actualizar periférico existente
                    $queryPeriferico = "UPDATE periferico SET tipo_conexion = :tipo_conexion, marca = :marca, garantia_meses = :garantia_meses 
                                        WHERE id_producto = :id_producto";
                } else {
                    // Insertar nuevo periférico
                    $queryPeriferico = "INSERT INTO periferico (id_producto, tipo_conexion, marca, garantia_meses) 
                                        VALUES (:id_producto, :tipo_conexion, :marca, :garantia_meses)";
                }
                $stmtPeriferico = $this->db->prepare($queryPeriferico);
                $stmtPeriferico->bindParam(':id_producto', $id, PDO::PARAM_INT);
                $stmtPeriferico->bindParam(':tipo_conexion', $data['tipo_conexion']);
                $stmtPeriferico->bindParam(':marca', $data['marca']);
                $stmtPeriferico->bindParam(':garantia_meses', $data['garantia_meses'], PDO::PARAM_INT);
                
                if (!$stmtPeriferico->execute()) {
                    throw new Exception("Error al actualizar periférico");
                }
            }
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function delete($id) {
        try {
            $this->db->beginTransaction();
            
            // Eliminar de tablas hijas primero (por restricciones de clave foránea)
            $this->db->prepare("DELETE FROM accesorio WHERE id_producto = :id")->execute([':id' => $id]);
            $this->db->prepare("DELETE FROM periferico WHERE id_producto = :id")->execute([':id' => $id]);
            
            // Eliminar de tabla productos
            $query = "DELETE FROM productos WHERE id_producto = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                throw new Exception("Error al eliminar producto");
            }
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getProveedores() {
        $query = "SELECT id_proveedor, razon_social FROM proveedores";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Método para obtener estadísticas por tipo
    public function getEstadisticasPorTipo() {
        $query = "SELECT 
                    SUM(CASE WHEN a.id_producto IS NOT NULL THEN 1 ELSE 0 END) as total_accesorios,
                    SUM(CASE WHEN pe.id_producto IS NOT NULL THEN 1 ELSE 0 END) as total_perifericos,
                    SUM(CASE WHEN a.id_producto IS NULL AND pe.id_producto IS NULL THEN 1 ELSE 0 END) as total_generales,
                    COUNT(*) as total_productos
                  FROM productos p 
                  LEFT JOIN accesorio a ON p.id_producto = a.id_producto
                  LEFT JOIN periferico pe ON p.id_producto = pe.id_producto";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }
}