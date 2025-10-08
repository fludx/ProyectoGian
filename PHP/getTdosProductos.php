<?php
header('Content-Type: application/json');
require_once 'conexion.php';

$conn = conexion();
if (!$conn) {
    echo json_encode(['error'=>'Error de conexión']);
    exit;
}

$sql = "SELECT Id_Producto AS id, Nombre AS nombre, Descripcion AS descripcion, Precio, Cantidad, Categoria, Imagen FROM Productos ORDER BY Nombre";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error'=>$conn->error]);
    exit;
}

$productos = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($productos);

$conn->close();
?>
