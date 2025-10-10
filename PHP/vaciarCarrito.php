<?php
session_start();
header('Content-Type: application/json');
require_once "conexion.php";

$conn = conexion();

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["success" => false, "message" => "Usuario no logueado"]);
    exit;
}

$idUsuario = $_SESSION['usuario_id'];

$sql = "DELETE FROM Carrito WHERE Id_Usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();

echo json_encode(["success" => true, "message" => "Carrito vaciado"]);

$conn->close();
?>
