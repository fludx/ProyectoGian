<?php
error_reporting(0);
header('Content-Type: application/json');
session_start();
require_once "conexion.php";

$conn = conexion();

// Tomar idUsuario y idProducto
$idUsuario = $_SESSION['usuario_id'] ?? $_POST['idUsuario'] ?? 0;
$idProducto = $_POST['id'] ?? 0;

if ($idUsuario <= 0 || $idProducto <= 0) {
    echo json_encode(["status"=>"error","message"=>"Usuario o producto inválido"]);
    exit;
}

try {
    // Verifica si el producto ya está en el carrito
    $sqlCheck = "SELECT Cantidad FROM Carrito WHERE Id_Usuario=? AND Id_Producto=?";
    $stmt = $conn->prepare($sqlCheck);
    $stmt->bind_param("ii", $idUsuario, $idProducto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Incrementar cantidad
        $row = $result->fetch_assoc();
        $cantidadNueva = $row['Cantidad'] + 1;
        $sqlUpdate = "UPDATE Carrito SET Cantidad=? WHERE Id_Usuario=? AND Id_Producto=?";
        $stmt2 = $conn->prepare($sqlUpdate);
        $stmt2->bind_param("iii", $cantidadNueva, $idUsuario, $idProducto);
        $stmt2->execute();
    } else {
        // Insertar nuevo
        $sqlInsert = "INSERT INTO Carrito (Id_Usuario, Id_Producto, Cantidad) VALUES (?,?,1)";
        $stmt2 = $conn->prepare($sqlInsert);
        $stmt2->bind_param("ii", $idUsuario, $idProducto);
        $stmt2->execute();
    }

    echo json_encode(["status"=>"ok","message"=>"Producto agregado"]);

} catch (Exception $e) {
    echo json_encode(["status"=>"error","message"=>$e->getMessage()]);
}

$conn->close();
?>
