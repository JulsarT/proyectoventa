<?php
// modelo/Producto.php
require_once __DIR__ . '/../core/Database.php';

class Producto extends CoreDatabase
{

    // Obtener todos los productos con información de tipo
    public function getAll()
    {
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

    // 🔹 NUEVO: Obtener productos con filtros dinámicos
    public function getFiltrados($categoria = null, $ordenPrecio = null, $ordenStock = null)
    {
        $query = "SELECT p.*, pr.razon_social,
                  CASE 
                    WHEN a.id_producto IS NOT NULL THEN 'accesorio'
                    WHEN pe.id_producto IS NOT NULL THEN 'periferico'
                    ELSE 'general'
                  END as tipo_producto
                  FROM productos p 
                  LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor
                  LEFT JOIN accesorio a ON p.id_producto = a.id_producto
                  LEFT JOIN periferico pe ON p.id_producto = pe.id_producto
                  WHERE 1";

        // 🔸 Filtrar por categoría (tipo)
        if (!empty($categoria)) {
            if ($categoria === 'accesorio') {
                $query .= " AND a.id_producto IS NOT NULL";
            } elseif ($categoria === 'periferico') {
                $query .= " AND pe.id_producto IS NOT NULL";
            }
        }

        // 🔸 Orden por precio o stock
        if ($ordenPrecio) {
            if ($ordenPrecio === 'asc') {
                $query .= " ORDER BY p.precio ASC";
            } elseif ($ordenPrecio === 'desc') {
                $query .= " ORDER BY p.precio DESC";
            }
        } elseif ($ordenStock) {
            if ($ordenStock === 'asc') {
                $query .= " ORDER BY p.stock ASC";
            } elseif ($ordenStock === 'desc') {
                $query .= " ORDER BY p.stock DESC";
            }
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Obtener solo accesorios con sus atributos específicos
    public function getAccesorios()
    {
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
    public function getPerifericos()
    {
        $query = "SELECT p.*, pr.razon_social, pe.tipo_conexion, pe.marca, pe.garantia_meses,
                  'periferico' as tipo_producto
                  FROM productos p 
                  LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor
                  INNER JOIN periferico pe ON p.id_producto = pe.id_producto";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
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

    public function create($data, $imagePath = null)
    {
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
                $stmtAccesorio->execute();
            } elseif ($data['tipo_producto'] === 'periferico') {
                $queryPeriferico = "INSERT INTO periferico (id_producto, tipo_conexion, marca, garantia_meses) 
                                    VALUES (:id_producto, :tipo_conexion, :marca, :garantia_meses)";
                $stmtPeriferico = $this->db->prepare($queryPeriferico);
                $stmtPeriferico->bindParam(':id_producto', $productId, PDO::PARAM_INT);
                $stmtPeriferico->bindParam(':tipo_conexion', $data['tipo_conexion']);
                $stmtPeriferico->bindParam(':marca', $data['marca']);
                $stmtPeriferico->bindParam(':garantia_meses', $data['garantia_meses'], PDO::PARAM_INT);
                $stmtPeriferico->execute();
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function update($id, $data, $imagePath = null)
    {
        try {
            $this->db->beginTransaction();

            // Actualizar en tabla productos
            $query = "UPDATE productos SET 
                  nombre = :nombre, 
                  descripcion = :descripcion, 
                  precio = :precio, 
                  stock = :stock, 
                  id_proveedor = :id_proveedor";

            // Solo actualizar la imagen si se proporciona una nueva
            if ($imagePath !== null) {
                $query .= ", imagen = :imagen";
            }

            $query .= " WHERE id_producto = :id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':descripcion', $data['descripcion']);
            $stmt->bindParam(':precio', $data['precio']);
            $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
            $stmt->bindParam(':id_proveedor', $data['id_proveedor'], PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($imagePath !== null) {
                $stmt->bindParam(':imagen', $imagePath);
            }

            if (!$stmt->execute()) {
                throw new Exception("Error al actualizar producto");
            }

            // Eliminar registros anteriores de accesorio y periférico
            $deleteAccesorio = "DELETE FROM accesorio WHERE id_producto = :id";
            $stmtDeleteAcc = $this->db->prepare($deleteAccesorio);
            $stmtDeleteAcc->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtDeleteAcc->execute();

            $deletePeriferico = "DELETE FROM periferico WHERE id_producto = :id";
            $stmtDeletePer = $this->db->prepare($deletePeriferico);
            $stmtDeletePer->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtDeletePer->execute();

            // Insertar en tabla específica según el tipo
            if ($data['tipo_producto'] === 'accesorio') {
                $queryAccesorio = "INSERT INTO accesorio (id_producto, material, color, compatibilidad) 
                               VALUES (:id_producto, :material, :color, :compatibilidad)";
                $stmtAccesorio = $this->db->prepare($queryAccesorio);
                $stmtAccesorio->bindParam(':id_producto', $id, PDO::PARAM_INT);
                $stmtAccesorio->bindParam(':material', $data['material']);
                $stmtAccesorio->bindParam(':color', $data['color']);
                $stmtAccesorio->bindParam(':compatibilidad', $data['compatibilidad']);
                $stmtAccesorio->execute();
            } elseif ($data['tipo_producto'] === 'periferico') {
                $queryPeriferico = "INSERT INTO periferico (id_producto, tipo_conexion, marca, garantia_meses) 
                                VALUES (:id_producto, :tipo_conexion, :marca, :garantia_meses)";
                $stmtPeriferico = $this->db->prepare($queryPeriferico);
                $stmtPeriferico->bindParam(':id_producto', $id, PDO::PARAM_INT);
                $stmtPeriferico->bindParam(':tipo_conexion', $data['tipo_conexion']);
                $stmtPeriferico->bindParam(':marca', $data['marca']);
                $stmtPeriferico->bindParam(':garantia_meses', $data['garantia_meses'], PDO::PARAM_INT);
                $stmtPeriferico->execute();
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error en update: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $this->db->beginTransaction();

            // Primero obtener la imagen para eliminarla del servidor
            $queryImagen = "SELECT imagen FROM productos WHERE id_producto = :id";
            $stmtImagen = $this->db->prepare($queryImagen);
            $stmtImagen->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtImagen->execute();
            $producto = $stmtImagen->fetch();

            // Eliminar la imagen del servidor si existe
            if ($producto && !empty($producto['imagen'])) {
                $imagePath = __DIR__ . '/../' . $producto['imagen'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Eliminar de tabla accesorio (si existe)
            $deleteAccesorio = "DELETE FROM accesorio WHERE id_producto = :id";
            $stmtDeleteAcc = $this->db->prepare($deleteAccesorio);
            $stmtDeleteAcc->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtDeleteAcc->execute();

            // Eliminar de tabla periferico (si existe)
            $deletePeriferico = "DELETE FROM periferico WHERE id_producto = :id";
            $stmtDeletePer = $this->db->prepare($deletePeriferico);
            $stmtDeletePer->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtDeletePer->execute();

            // Finalmente eliminar de tabla productos
            $deleteProducto = "DELETE FROM productos WHERE id_producto = :id";
            $stmtDeleteProd = $this->db->prepare($deleteProducto);
            $stmtDeleteProd->bindParam(':id', $id, PDO::PARAM_INT);

            if (!$stmtDeleteProd->execute()) {
                throw new Exception("Error al eliminar producto");
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error en delete: " . $e->getMessage());
            return false;
        }
    }

    public function getProveedores()
    {
        $query = "SELECT id_proveedor, razon_social FROM proveedores";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Método para obtener estadísticas por tipo
    public function getEstadisticasPorTipo()
    {
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

    public function getProductosStockMinimo($limite = 5)
    {
        $query = "SELECT p.*, 
          CASE WHEN a.id_producto IS NOT NULL THEN 'accesorio' 
               WHEN pe.id_producto IS NOT NULL THEN 'periferico'
               ELSE 'general' END as tipo_producto
          FROM productos p
          LEFT JOIN accesorio a ON p.id_producto = a.id_producto
          LEFT JOIN periferico pe ON p.id_producto = pe.id_producto
          WHERE p.stock <= :limite
          ORDER BY p.stock ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductosConStockBajo($limite = 5)
    {
        $query = "SELECT id_producto, nombre, stock 
              FROM productos 
              WHERE stock <= :limite 
              ORDER BY stock ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Ajustar precios para mostrar precio de venta (30% más)
    private function aplicarMargenVenta($productos)
    {
        foreach ($productos as &$p) {
            if (isset($p['precio'])) {
                $p['precio_venta'] = round($p['precio'] * 1.30, 2);
            }
        }
        return $productos;
    }

    // 🔹 Sobrescribir funciones que devuelven productos
    public function getAllConMargen()
    {
        $productos = $this->getAll();
        return $this->aplicarMargenVenta($productos);
    }

    public function getFiltradosConMargen($categoria = null, $ordenPrecio = null, $ordenStock = null)
    {
        $productos = $this->getFiltrados($categoria, $ordenPrecio, $ordenStock);
        return $this->aplicarMargenVenta($productos);
    }

    public function getByIdConMargen($id)
    {
        $producto = $this->getById($id);
        if ($producto && isset($producto['precio'])) {
            $producto['precio_venta'] = round($producto['precio'] * 1.30, 2);
        }
        return $producto;
    }
}
