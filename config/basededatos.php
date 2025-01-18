<?php

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_nombre = "negociosdb";

$conexion = null;

try {

    $conexion = mysqli_connect($db_server, $db_user, $db_pass, $db_nombre);

    if (!$conexion) {
        throw new Exception("No se pudo conectar a la base de datos: " . mysqli_connect_error());
    }

} catch (Exception $e) {
    die("Error en la conexión: " . $e->getMessage());
}

if ($conexion) {
    echo "Conexión exitosa<br>";
} else {
    echo "Error en la conexión<br>";
}

?>
