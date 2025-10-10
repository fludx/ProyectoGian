<?php
session_start();
header('Content-Type: application/json');
require_once "conexion.php";

$conn = conexion();

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["status" => "error", "message" => "Usuario no logueado", "productos" => []]);
    exit;
}

$idUsuario = $_SESSION['usuario_id'];

$sql = "SELECT 
            c.Id_Carrito,
            p.Id_Producto,
            p.Nombre,
            c.Cantidad
        FROM Carrito c
        JOIN Productos p ON c.Id_Producto = p.Id_Producto
        WHERE c.Id_Usuario = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();

$carrito = [];
while ($row = $result->fetch_assoc()) {
    $carrito[] = [
        "Id_Carrito" => $row['Id_Carrito'],
        "Id_Producto" => $row['Id_Producto'],
        "Nombre" => $row['Nombre'],
        "Cantidad" => $row['Cantidad'],
        "Imagen" => "" // sin imagen
    ];
}

echo json_encode([
    "status" => "ok",
    "productos" => $carrito
]);

$conn->close();
?>
