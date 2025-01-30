<?php

require_once __DIR__ . '/../config/basededatos.php';

class ProductoController {
    private $conexion;

    public function __construct() {
        global $conexion;
        $this->conexion = $conexion;
    }

    public function getProductos() {
        $sql = "SELECT * FROM productos WHERE estado = 'activo'";
        $resultado = mysqli_query($this->conexion, $sql);

        $productos = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $productos[] = $fila;
        }
        return $productos; // Devuelve un array con todos los productos activos
    }

    public function createProducto($nombre, $categoria, $descripcion, $precio, $imagen, $vendedor_id) {
        $rutaImagenes = __DIR__ . "/../uploads/";
        $nombreImagen = uniqid() . "_" . basename($imagen['name']);
        $rutaCompleta = $rutaImagenes . $nombreImagen;
    
        // Verifica que el directorio existe
        if (!is_dir($rutaImagenes)) {
            mkdir($rutaImagenes, 0755, true);
        }
    
        // Mover la imagen al directorio de uploads
        if (!move_uploaded_file($imagen['tmp_name'], $rutaCompleta)) {
            return ["success" => false, "message" => "Error al guardar la imagen."];
        }
    
        $sql = "INSERT INTO productos (nombre, categoria, descripcion, precio, imagen, estado, vendedor_id) 
                VALUES (?, ?, ?, ?, ?, 'activo', ?)";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "sssdsd", $nombre, $categoria, $descripcion, $precio, $nombreImagen, $vendedor_id);
    
        if (mysqli_stmt_execute($stmt)) {
            return ["success" => true, "id" => mysqli_insert_id($this->conexion), "imagen" => $nombreImagen];
        } else {
            return ["success" => false, "message" => "Error al crear el producto en la base de datos."];
        }
    }
    
    
    
    
    

    public function getProductoPorId($id) {
        $sql = "SELECT * FROM productos WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($resultado);
    }

    public function updateProducto($id, $nombre, $categoria, $descripcion, $precio, $imagen) {
        $sql = "UPDATE productos 
                SET nombre = ?, categoria = ?, descripcion = ?, precio = ?, imagen = ? 
                WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "sssdsi", $nombre, $categoria, $descripcion, $precio, $imagen, $id);

        if (mysqli_stmt_execute($stmt)) {
            return ["success" => true, "message" => "Producto actualizado correctamente."];
        } else {
            return ["success" => false, "message" => "Error al actualizar el producto."];
        }
    }

    public function deleteProducto($id) {
        $sql = "UPDATE productos SET estado = 'inactivo' WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
    
        if (mysqli_stmt_execute($stmt)) {
            return ["success" => true, "message" => "Producto marcado como inactivo correctamente."];
        } else {
            return ["success" => false, "message" => "Error al marcar el producto como inactivo."];
        }
    }    
    
}

?>
