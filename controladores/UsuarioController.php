<?php

require_once __DIR__ . '/../config/basededatos.php';

class UsuarioController {
    private $conexion;

    public function __construct() {
        global $conexion;
        $this->conexion = $conexion;
    }

    public function getUsuarios() {
        $sql = "SELECT * FROM usuarios";
        $resultado = mysqli_query($this->conexion, $sql);

        $usuarios = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $usuarios[] = $fila;
        }
        return $usuarios; 
    }

    public function getUsuarioPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($resultado); 
    }

  
    public function createUsuario($nombre, $email, $password, $rol) {
        //Encripta la contrasena
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    
        $sql = "INSERT INTO usuarios (nombre, email, clave, rol) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $nombre, $email, $passwordHash, $rol);
    
        try {
            if (mysqli_stmt_execute($stmt)) {
                return ["success" => true, "id" => mysqli_insert_id($this->conexion)];
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                return ["success" => false, "message" => "El correo electrónico ya está registrado."];
            } else {
                throw $e; // Lanza otros errores
            }
        }
    }    
    
    public function updateUsuario($id, $nombre, $email, $password = null, $rol) {
        // Verificar si el correo ya existe en otro usuario
        $sqlCheck = "SELECT id FROM usuarios WHERE email = ? AND id != ?";
        $stmtCheck = mysqli_prepare($this->conexion, $sqlCheck);
        mysqli_stmt_bind_param($stmtCheck, "si", $email, $id);
        mysqli_stmt_execute($stmtCheck);
        $resultadoCheck = mysqli_stmt_get_result($stmtCheck);
    
        if (mysqli_fetch_assoc($resultadoCheck)) {
            return ["success" => false, "message" => "Error: El correo ya está registrado por otro usuario."];
        }
    
        // Si el correo no está duplicado, proceder a la actualización
        if ($password) {
            // Si se proporciona una contraseña, también se actualiza
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE usuarios SET nombre = ?, email = ?, contraseña = ?, rol = ? WHERE id = ?";
            $stmt = mysqli_prepare($this->conexion, $sql);
            mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $email, $passwordHash, $rol, $id);
        } else {
            $sql = "UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id = ?";
            $stmt = mysqli_prepare($this->conexion, $sql);
            mysqli_stmt_bind_param($stmt, "sssi", $nombre, $email, $rol, $id);
        }
    
        if (mysqli_stmt_execute($stmt)) {
            return ["success" => true, "message" => "Usuario actualizado correctamente."];
        } else {
            return ["success" => false, "message" => "Error al actualizar el usuario."];
        }
    }
    
}

?>
