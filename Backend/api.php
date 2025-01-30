<?php
header("Access-Control-Allow-Origin: *"); // Permitir solicitudes desde el frontend
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/config/basededatos.php';
require_once __DIR__ . '/controladores/UsuarioController.php';
require_once __DIR__ . '/controladores/ProductoController.php';
require_once __DIR__ . '/controladores/TransaccionController.php';
// Agrega otros controladores si es necesario

$usuarioController = new UsuarioController();
$productoController = new ProductoController();
$transaccionController = new TransaccionController();

// Detectar el tipo de recurso y método solicitado
$path = $_GET['path'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

switch ($path) {
    case 'usuario':
        if ($method === 'GET' && isset($_GET['id'])) {
            // Obtener usuario por ID
            $id = intval($_GET['id']);
            $usuario = $usuarioController->getUsuarioPorId($id);
            echo json_encode($usuario);
        } elseif ($method === 'GET') {
            // Obtener todos los usuarios
            $usuarios = $usuarioController->getUsuarios();
            echo json_encode($usuarios);
        } elseif ($method === 'POST') {
            // Crear un usuario
            $data = json_decode(file_get_contents("php://input"), true);
            $response = $usuarioController->createUsuario($data['nombre'], $data['email'], $data['password']);
            echo json_encode($response);
        }
        break;

    case 'producto':
        if ($method === 'GET') {
            // Obtener todos los productos
            $productos = $productoController->getProductos();
            echo json_encode($productos);
        } elseif ($method === 'POST') {
            $nombre = $_POST['nombre'];
            $categoria = $_POST['categoria'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $imagen = $_FILES['imagen'];
            $vendedor_id = $_POST['vendedor_id'];
    
            $response = $productoController->createProducto($nombre, $categoria, $descripcion, $precio, $imagen, $vendedor_id);
            echo json_encode($response);
        } else {
            echo json_encode(["success" => false, "message" => "Método no permitido"]);
        }
        break;
        
    case 'transaccion':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $response = $transaccionController->realizarTransaccion($data['productos'], $data['comprador_id']);
            echo json_encode($response);
        } else {
            echo json_encode(["success" => false, "message" => "Método no permitido"]);
        }
        break;
    
    case 'ventas':
        if ($method === 'GET' && isset($_GET['vendedor_id'])) {
            $vendedorId = intval($_GET['vendedor_id']);
            $ventasPorMes = $transaccionController->contarVentasPorMes($vendedorId);
            echo json_encode($ventasPorMes);
        } else {
            echo json_encode(["success" => false, "message" => "Método no permitido o vendedor_id faltante"]);
        }
        break;
        

case 'ventas-precios':
    if ($method === 'GET' && isset($_GET['vendedor_id'])) {
        $vendedor_id = intval($_GET['vendedor_id']);
        $query = "
            SELECT p.precio 
            FROM transacciones t
            INNER JOIN productos p ON t.producto_id = p.id
            WHERE p.vendedor_id = ?
        ";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $vendedor_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $precios = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $precios[] = $row; // Guardar cada precio en el arreglo
        }

        echo json_encode($precios);
    } else {
        echo json_encode(["success" => false, "message" => "Método no permitido"]);
    }
    break;


    case 'login':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $response = $usuarioController->authenticateUsuario($data['email'], $data['password']);
            echo json_encode($response);
        } else {
            echo json_encode(["success" => false, "message" => "Método no permitido"]);
        }
        break;
    

    default:
        echo json_encode(["error" => "Ruta no válida"]);
        break;
}
?>
