<?php
require_once __DIR__ . '/../config/basededatos.php';

class TransaccionController {
    private $db;

    public function __construct() {
        global $conexion; // Usamos la conexión global
        
        if (!$conexion) {
            die("Error: No se pudo conectar a la base de datos.");
        }
        
        $this->db = $conexion;
    }

    public function realizarTransaccion($productos, $compradorId) {
        mysqli_begin_transaction($this->db);
        try {
            // Registrar cada producto como una transacción individual
            foreach ($productos as $producto) {
                // Insertar una transacción por cada producto comprado
                $query = "INSERT INTO transacciones (producto_id, comprador_id, fecha) VALUES (?, ?, NOW())";
                $stmt = mysqli_prepare($this->db, $query);
                mysqli_stmt_bind_param($stmt, "ii", $producto['id'], $compradorId);
                mysqli_stmt_execute($stmt);

                // Desactivar el producto (ya no está disponible para venta)
                $query = "UPDATE productos SET estado = 'inactivo' WHERE id = ?";
                $stmt = mysqli_prepare($this->db, $query);
                mysqli_stmt_bind_param($stmt, "i", $producto['id']);
                mysqli_stmt_execute($stmt);
            }

            mysqli_commit($this->db);
            return ["success" => true, "message" => "Transacción realizada con éxito"];
        } catch (Exception $e) {
            mysqli_rollback($this->db);
            return ["success" => false, "message" => "Error en la transacción: " . $e->getMessage()];
        }
    }

    public function contarVentasPorMes($vendedorId) {
        $sql = "
            SELECT 
                MONTH(t.fecha) AS mes, 
                COUNT(t.id) AS ventas
            FROM 
                transacciones t
            JOIN 
                productos p ON t.producto_id = p.id
            WHERE 
                p.vendedor_id = ?
            GROUP BY 
                MONTH(t.fecha)
        ";
    
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, "i", $vendedorId);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
    
        $ventasPorMes = array_fill(1, 12, 0); // Inicializamos los meses con 0 ventas
    
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $ventasPorMes[(int)$fila['mes']] = (int)$fila['ventas'];
        }
    
        return $ventasPorMes; // Devuelve un array con las ventas por mes
    }
    
}
?>