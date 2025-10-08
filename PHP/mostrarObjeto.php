<?php
header('Content-Type: application/json');
require_once 'conexion.php';

$conn = conexion();
if (!$conn) {
    echo json_encode(['error' => 'Error de conexión']);
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $conn->prepare("SELECT Id_Producto AS id, Nombre AS nombre, Descripcion AS descripcion, Precio AS precio, Cantidad AS cantidad, Categoria AS categoria FROM Productos WHERE Id_Producto = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $productos = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($productos);
} else {
    echo json_encode([]);
}

$conn->close();
?>
