<?php
error_reporting(0);
header('Content-Type: application/json');
session_start();
require_once "conexion.php";

$conn = conexion();

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["status" => "error", "message" => "Usuario no logueado"]);
    exit;
}

$idUsuario = $_SESSION['usuario_id'];
$idCarrito = $_POST['id'] ?? 0;

if ($idCarrito <= 0) {
    echo json_encode(["status" => "error", "message" => "ID de carrito inválido"]);
    exit;
}

try {
    // Eliminar solo si el carrito pertenece al usuario
    $sql = "DELETE FROM Carrito WHERE Id_Carrito = ? AND Id_Usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idCarrito, $idUsuario);
    $stmt->execute();

    echo json_encode(["status" => "ok", "message" => "Producto eliminado"]);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

$conn->close();
