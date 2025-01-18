<?php
require_once 'controladores/UsuarioController.php';
require_once 'controladores/ProductoController.php';
require_once 'controladores/TransaccionController.php';

// Inicializar controladores
$usuarioController = new UsuarioController();
$productoController = new ProductoController();
$transaccionController = new TransaccionController();

// ==========================================
// 1. Crear un nuevo usuario
// ==========================================
echo "=== Crear un Usuario ===<br>";
$usuarioResultado = $usuarioController->createUsuario("Ana Pérez", "ana@example.com", "mypassword123", "comprador");
if ($usuarioResultado['success']) {
    $usuarioId = $usuarioResultado['id'];
    echo "Usuario creado con éxito. ID: $usuarioId<br>";
} else {
    echo "Error al crear usuario: " . $usuarioResultado['message'] . "<br>";
    exit;
}

// ==========================================
// 2. Actualizar el usuario creado
// ==========================================
echo "=== Actualizar el Usuario ===<br>";
$actualizacionUsuario = $usuarioController->updateUsuario($usuarioId, "Ana Actualizada", "ana@example.com", null, "vendedor");
if (is_array($actualizacionUsuario)) {
    echo $actualizacionUsuario['message'] . "<br>";
} else {
    echo "Error al actualizar usuario.<br>";
}

// ==========================================
// 3. Crear un nuevo producto asociado al usuario
// ==========================================
echo "=== Crear un Producto ===<br>";
$productoResultado = $productoController->createProducto("Laptop", "Electrónica", "Laptop de alta gama", 999.99, "imagen_laptop.jpg", $usuarioId);
if ($productoResultado['success']) {
    $productoId = $productoResultado['id'];
    echo "Producto creado con éxito. ID: $productoId<br>";
} else {
    echo "Error al crear producto: " . $productoResultado['message'] . "<br>";
    exit;
}

// ==========================================
// 4. Actualizar el producto creado
// ==========================================
echo "=== Actualizar el Producto ===<br>";
$actualizacionProducto = $productoController->updateProducto($productoId, "Laptop Gamer", "Electrónica", "Laptop para juegos de última generación", 1299.99, "imagen_gamer.jpg");
if (is_array($actualizacionProducto)) {
    echo $actualizacionProducto['message'] . "<br>";
} else {
    echo "Error al actualizar producto.<br>";
}

// ==========================================
// 5. Crear una transacción asociada al producto y usuario
// ==========================================
echo "=== Crear una Transacción ===<br>";
$transaccionResultado = $transaccionController->createTransaccion($productoId, $usuarioId);
if ($transaccionResultado['success']) {
    $transaccionId = $transaccionResultado['id'];
    echo "Transacción creada con éxito. ID: $transaccionId<br>";
} else {
    echo "Error al crear transacción: " . $transaccionResultado['message'] . "<br>";
    exit;
}

// ==========================================
// 6. Mostrar el historial de compras del usuario
// ==========================================
echo "=== Historial de Compras ===<br>";
$historialCompras = $transaccionController->getHistorialCompras($usuarioId);
if (!empty($historialCompras)) {
    echo "Historial de compras del usuario:<br>";
    echo "<pre>";
    print_r($historialCompras);
    echo "</pre>";
} else {
    echo "El usuario no tiene transacciones registradas.<br>";
}

// ==========================================
// 7. Marcar el producto como inactivo
// ==========================================
echo "=== Marcar el Producto como Inactivo ===<br>";
$eliminarProducto = $productoController->deleteProducto($productoId);
if (is_array($eliminarProducto)) {
    echo $eliminarProducto['message'] . "<br>";
} else {
    echo "Error al marcar producto como inactivo.<br>";
}
?>
