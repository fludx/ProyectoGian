<?php
require_once "conexion.php";
header('Content-Type: application/json');

$conn = conexion();

try {
    $sql = "SELECT p.Id_Producto, p.Nombre
            FROM Productos p";

    $result = mysqli_query($conn, $sql);

    $productos = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $productos[] = [
            "Id_Producto" => $row['Id_Producto'],
            "Nombre" => $row['Nombre'],
            "ImagenURL" => "" // sin imagen por ahora
        ];
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

mysqli_close($conn);
?>
