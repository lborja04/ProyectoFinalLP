<?php

require_once __DIR__ . '/../config/basededatos.php';

class TransaccionController {
    private $conexion;

    public function __construct() {
        global $conexion;
        $this->conexion = $conexion;
    }

    public function createTransaccion($producto_id, $comprador_id) {
        // Verificar que el producto está activo y no reservado
        $sqlCheck = "SELECT estado FROM productos WHERE id = ? AND estado = 'activo'";
        $stmtCheck = mysqli_prepare($this->conexion, $sqlCheck);
        mysqli_stmt_bind_param($stmtCheck, "i", $producto_id);
        mysqli_stmt_execute($stmtCheck);
        $resultadoCheck = mysqli_stmt_get_result($stmtCheck);

        if (mysqli_fetch_assoc($resultadoCheck) === null) {
            return ["success" => false, "message" => "El producto no está disponible para la compra."];
        }

        // Registrar la transacción
        $sql = "INSERT INTO transacciones (producto_id, comprador_id, fecha) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $producto_id, $comprador_id);

        if (mysqli_stmt_execute($stmt)) {
            // Cambiar el estado del producto a reservado
            $sqlUpdate = "UPDATE productos SET estado = 'reservado' WHERE id = ?";
            $stmtUpdate = mysqli_prepare($this->conexion, $sqlUpdate);
            mysqli_stmt_bind_param($stmtUpdate, "i", $producto_id);
            mysqli_stmt_execute($stmtUpdate);

            return ["success" => true, "id" => mysqli_insert_id($this->conexion)];
        } else {
            return ["success" => false, "message" => "Error al registrar la transacción."];
        }
    }

    public function getHistorialCompras($comprador_id) {
        $sql = "SELECT t.id AS transaccion_id, t.fecha, p.nombre AS producto, p.precio, p.categoria
                FROM transacciones t
                INNER JOIN productos p ON t.producto_id = p.id
                WHERE t.comprador_id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $comprador_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        $transacciones = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $transacciones[] = $fila;
        }
        return $transacciones;
    }

}

?>
