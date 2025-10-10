<?php
error_reporting(0);
header('Content-Type: application/json');
session_start();
require_once "conexion.php";

$conn = conexion();

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Usuario no logueado",
        "productos" => []
    ]);
    exit;
}

$idUsuario = $_SESSION['usuario_id'];

try {
    $sql = "SELECT c.Id_Carrito, p.Id_Producto, p.Nombre
            FROM Carrito c
            INNER JOIN Productos p ON c.Id_Producto = p.Id_Producto
            WHERE c.Id_Usuario = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();

    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }

    echo json_encode([
        "status" => "ok",
        "productos" => $productos
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage(),
        "productos" => []
    ]);
}

$conn->close();
